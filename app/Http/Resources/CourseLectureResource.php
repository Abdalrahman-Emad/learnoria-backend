<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseLectureResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'duration_minutes' => $this->duration_minutes,
            'duration_formatted' => $this->duration_formatted,
            'type' => $this->type,
            'order_index' => $this->order_index,
            'is_free_preview' => $this->is_free_preview,
        ];
    }
}
