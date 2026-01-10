<?php

namespace App\Http\Controllers\Api\Post;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\PostRejectReason;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (auth()->user()->user_type === 'admin') {
            $posts = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.replies.user'
            ])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        return PostResource::collection($posts);
        } else {
            $posts = Post::where('status','active')->with([
            'user',
            'likes',
            'comments.user',
            'comments.replies.user'
            ])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        return PostResource::collection($posts);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $post = Post::create([
            'content' => $request->content,
            'user_id' => $request->user()->id, // or auth()->id()
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Post created successfully',
            'data'    => $post,
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'status' => 'show'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
            Gate::authorize('update', $post);

            $request->validate([
                'content' => 'required|string|max:5000',
            ]);

            $post->update([
                'content' => $request->content,
            ]);

            return response()->json([
                'status'  => 1,
                'message' => 'Post updated successfully',
                'data'    => $post,
            ]);
    }
    

    public function pendingPosts() {
        if (auth()->user()->user_type === 'admin') {
            $posts = Post::where('status','pending')->with([
            'user',
            'likes',
            'comments.user',
            'comments.replies.user'
            ])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

            return PostResource::collection($posts);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You dont have permission to view pending posts.'
            ]);
        }
    }

    public function addComment(Request $request) {
        $request->validate([
            'post_id' => 'required|numeric',
            'comment' => 'required|string|max:5000',
        ]);
        
        $comment = Comment::create([
            'content'   => $request->comment,
            'user_id'   => $request->user()->id,
            'post_id'   => $request->post_id,
            'parent_id'=> $request->parent_id,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Comment created successfully',
            'data'    => $comment,
        ], 201);
    }

    public function postLike(Request $request) {
        $request->validate([
            'post_id' => 'required|numeric',
        ]);

        $userId = $request->user()->id;
        $alreadyLiked = Like::where('user_id', $userId)
        ->where('post_id', $request->post_id)
        ->exists();

        if ($alreadyLiked) {
            return response()->json([
                'status'  => 0,
                'message' => 'You already liked this post.',
            ], 409);
        }
        
        $like = Like::create([
            'user_id'   => $userId,
            'post_id'   => $request->post_id,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Liked',
            'data'    => $like,
        ], 201);
    }
    
    public function approve($id) {
        $post = Post::findOrFail($id);

        if($post->status === 'active') {
            return response()->json([
               'status' => 'error',
               'message' => 'the post is already active'
            ]);
        }

        $post->update([
            'status' => 'active'
        ]);

        // return PostResource::collection($post);
        return new PostResource($post);
    }

    public function reject(Request $request, $id) {

        $request->validate([
            'reason' => 'required|max:500'
        ]);
        $post = Post::findOrFail($id);

        if($post->status === 'rejected') {
            return response()->json([
                'status' => 'error',
                'message' => 'The post is already rejected'
            ]);
        }

        $post->update([
            'status' => 'rejected'
        ]);
        PostRejectReason::create([
            'user_id'   => $request->user()->id,
            'post_id' => $id,
            'reason' => $request->reason
        ]);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'status' => 'destroy'
        ]);
    }
}
