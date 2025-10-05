<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'rating_breakdown' => $this->rating_breakdown,
            'is_verified_purchase' => $this->is_verified_purchase,
            'is_featured' => $this->is_featured,
            'helpful_count' => $this->helpful_count,
            'completed_at' => $this->completed_at,
            'user' => [
                'id' => $this->user->id,  
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
