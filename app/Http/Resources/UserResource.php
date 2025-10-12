<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'city' => $this->city,
            // 'avatar' => $this->avatar ? Storage::disk('public')->url($this->avatar) : null,
            'avatar' => $this->avatar ?? null,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}