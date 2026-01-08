<?php

namespace App\Http\Controllers\Api\Post;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
