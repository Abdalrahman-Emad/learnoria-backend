<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'added_at' => $this->created_at,
            'course' => new CourseResource($this->whenLoaded('course')),
        ];
    }
}
