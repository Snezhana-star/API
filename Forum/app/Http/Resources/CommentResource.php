<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'text'=>$this->text,
            'created_at'=>$this->created_at,
            'user'=>[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'email'=>$this->user->email,
                'role'=>$this->user->role->name,
                ],
            'post_id'=>$this->post->id,
        ];
    }
}
