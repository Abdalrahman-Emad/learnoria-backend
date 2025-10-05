<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseInstructorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'experience' => $this->experience,
            'title' => $this->title,
            'company' => $this->company,
            'linkedin_url' => $this->linkedin_url,
            'image' => $this->image_url,
            'expertise' => $this->expertise,
            'years_experience' => $this->years_experience,
            'is_primary' => $this->is_primary,
        ];
    }
}
