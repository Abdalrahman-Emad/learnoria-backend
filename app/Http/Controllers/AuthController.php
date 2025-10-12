<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;

class AuthController extends Controller
{
    // ✅ Register new user
    public function register(RegisterRequest $request)
    {
        $userData = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
            'bio'      => $request->bio,
            'city'     => $request->city,
        ];

        // ✅ Upload avatar to Cloudinary (if provided)
        if ($request->hasFile('avatar')) {
            try {
                $filePath = $request->file('avatar')->getRealPath();
                
                $uploaded = (new UploadApi())->upload($filePath, [
                    'folder' => 'learnoria/avatars',
                    'transformation' => [
                        'width' => 400,
                        'height' => 400,
                        'crop' => 'fill',
                        'gravity' => 'face'
                    ]
                ]);

                $userData['avatar'] = $uploaded['secure_url'];
                $userData['avatar_public_id'] = $uploaded['public_id'];
            } catch (\Exception $e) {
                Log::error('Avatar upload failed during registration: ' . $e->getMessage());
                // Continue registration without avatar
            }
        }

        $user = User::create($userData);
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => new UserResource($user),
            'token'   => $token,
        ], 201);
    }

    // ✅ Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        if ($user->status !== 'active') {
            return response()->json(['message' => 'Account is inactive'], 403);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user'    => new UserResource($user),
            'token'   => $token,
        ]);
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // ✅ Get profile
    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    // ✅ Update profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'   => 'sometimes|required|string|max:255',
            'phone'  => 'nullable|string|max:20',
            'bio'    => 'nullable|string|max:1000',
            'city'   => 'nullable|string|max:100',
            'avatar' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:5120', // 5MB
        ]);

        $user = $request->user();
        $user->fill($request->only(['name', 'phone', 'bio', 'city']));

        // ✅ Handle avatar update
        if ($request->hasFile('avatar')) {
            try {
                // Delete old avatar from Cloudinary (if exists)
                if ($user->avatar_public_id) {
                    try {
                        Cloudinary::destroy($user->avatar_public_id);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old avatar: ' . $e->getMessage());
                    }
                }

                // Upload new avatar using UploadApi directly
                $filePath = $request->file('avatar')->getRealPath();
                
                $uploaded = (new UploadApi())->upload($filePath, [
                    'folder' => 'learnoria/avatars',
                    'transformation' => [
                        'width' => 400,
                        'height' => 400,
                        'crop' => 'fill',
                        'gravity' => 'face'
                    ]
                ]);

                $user->avatar = $uploaded['secure_url'];
                $user->avatar_public_id = $uploaded['public_id'];
            } catch (\Exception $e) {
                Log::error('Avatar upload failed: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Failed to upload avatar',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => new UserResource($user)
        ]);
    }

    // ✅ Delete avatar
    public function deleteAvatar(Request $request)
    {
        $user = $request->user();

        if ($user->avatar_public_id) {
            try {
                Cloudinary::destroy($user->avatar_public_id);
            } catch (\Exception $e) {
                Log::warning('Failed to delete avatar from Cloudinary: ' . $e->getMessage());
            }
        }

        $user->update([
            'avatar' => null,
            'avatar_public_id' => null,
        ]);

        return response()->json([
            'message' => 'Avatar deleted successfully',
            'user'    => new UserResource($user),
        ]);
    }
}