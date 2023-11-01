<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'role'=>$this->role->name,
            'email'=>$this->email,
            'own_posts'=>PostResource::collection($this->posts),
            'comments'=>CommentForUserResource::collection($this->comments),
            'favorite'=>FavoriteResource::collection($this->favorites)
        ];
    }
}
