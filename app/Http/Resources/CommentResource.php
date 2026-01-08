<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'content'   => $this->content,
            'user'      => [
                            'id' => $this->user->id,
                            'name' => $this->user->name,
                            ],
            'replies'   => CommentResource::collection($this->replies),
            'created_at'=> $this->created_at->diffForHumans(),
        ];
    }
}

