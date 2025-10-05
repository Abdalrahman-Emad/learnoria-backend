<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'order_index' => $this->order_index,
            'total_duration' => $this->total_duration,
            'lectures_count' => $this->lectures->count(),
            'lectures' => CourseLectureResource::collection($this->whenLoaded('lectures')),
        ];
    }
}