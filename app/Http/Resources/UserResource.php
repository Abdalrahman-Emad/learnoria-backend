<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'avatar' => $this->getAvatarUrl(),
            'avatar_public_id' => $this->avatar_public_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get properly formatted avatar URL
     */
    private function getAvatarUrl()
    {
        if (empty($this->avatar)) {
            return null;
        }

        $avatar = trim($this->avatar);

        // If it's already a full URL (Cloudinary), return as-is
        if (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://')) {
            return $avatar;
        }

        // Otherwise, it's a relative path (legacy local storage)
        // This handles old avatars that might still be stored locally
        return url('storage/' . ltrim($avatar, '/'));
    }
}