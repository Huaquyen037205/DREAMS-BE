<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);
        return response()->json($comment, 201);
    }
    public function index($postId)
{
    $comments = \App\Models\Comment::with('user')->where('post_id', $postId)->orderBy('created_at')->get();
    return response()->json($comments);
}
}
