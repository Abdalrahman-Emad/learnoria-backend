<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;


class CourseController extends Controller
{
    // ✅ GET /courses
    public function index(Request $request)
    {
        $query = Course::with(['provider', 'reviews'])->approved();

        // Filters
        if ($request->field) $query->byField($request->field);
        if ($request->city) $query->byCity($request->city);
        if ($request->min_price && $request->max_price) $query->byPriceRange($request->min_price, $request->max_price);
        if ($request->min_rating) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate($request->per_page ?? 15);
        return CourseResource::collection($courses);
    }

    // ✅ POST /courses
    public function store(CourseRequest $request)
    {
        $courseData = $request->validated();
        $courseData['provider_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->getRealPath();

            // ✅ استخدم UploadApi مباشرة
            $uploaded = (new UploadApi())->upload($filePath, [
                'folder' => 'learnoria/courses'
            ]);

            $courseData['image'] = $uploaded['secure_url'];
        }

        $course = Course::create($courseData);
        return new CourseResource($course->load('provider'));
    }

    // ✅ GET /courses/{course}
    public function show(Course $course)
    {
        $course->load([
            'provider',
            'sections.lectures',
            'instructors',
            'primaryInstructor',
            'reviews' => function ($query) {
                $query->with('user')
                    ->where('is_featured', true)
                    ->latest()
                    ->limit(5);
            },
            'coupons' => function ($query) {
                $query->where('is_active', true)
                    ->where('starts_at', '<=', now())
                    ->where('expires_at', '>=', now());
            }
        ]);

        return new CourseResource($course);
    }

    // ✅ PUT /courses/{course}
    public function update(CourseRequest $request, Course $course)
    {
        if ($course->provider_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $courseData = $request->validated();

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة من Cloudinary
            if ($course->image && str_contains($course->image, 'res.cloudinary.com')) {
                $publicId = pathinfo(parse_url($course->image, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::destroy('learnoria/courses/' . $publicId);
            }

            // ✅ رفع الصورة الجديدة
            $uploadedFileUrl = Cloudinary::uploadFile(
                $request->file('image')->getRealPath(),
                ['folder' => 'learnoria/courses']
            )->getSecurePath();

            $courseData['image'] = $uploadedFileUrl;
        }

        $course->update($courseData);
        return new CourseResource($course->load('provider'));
    }

    // ✅ DELETE /courses/{course}
    public function destroy(Course $course)
    {
        if ($course->provider_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // حذف صورة الكورس من Cloudinary
        if ($course->image && str_contains($course->image, 'res.cloudinary.com')) {
            $publicId = pathinfo(parse_url($course->image, PHP_URL_PATH), PATHINFO_FILENAME);
            Cloudinary::destroy('learnoria/courses/' . $publicId);
        }

        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }

    // ✅ GET /my-courses
    public function myCourses(Request $request)
    {
        $courses = Course::with(['reviews'])
            ->where('provider_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return CourseResource::collection($courses);
    }

    public function approve(Course $course)
    {
        $course->update(['status' => 'approved']);
        return response()->json(['message' => 'Course approved successfully']);
    }

    public function reject(Course $course)
    {
        $course->update(['status' => 'rejected']);
        return response()->json(['message' => 'Course rejected successfully']);
    }

    public function pending()
    {
        $courses = Course::with(['provider'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return CourseResource::collection($courses);
    }

    public function relatedCourses(Course $course)
    {
        $relatedCourses = Course::with(['provider', 'reviews'])
            ->where('provider_id', $course->provider_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'approved')
            ->limit(6)
            ->get();

        return CourseResource::collection($relatedCourses);
    }
}
