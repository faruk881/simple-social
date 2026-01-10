<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'status'  =>$this->status,
            'reject_reason' => $this->when(
                $this->status === 'rejected',
                optional($this->rejectReason)->reason
            ),
            'content' => $this->content,
            'author'  => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ],

            'likes_count' => $this->likes_count,
            'liked_by_me' => $this->likes->contains('user_id', auth()->id()),

            'comments' => CommentResource::collection($this->comments),

            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
