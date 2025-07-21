<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostReaction;

class PostReactionController extends Controller
{
    public function react(Request $request, $postId)
    {
        $validated = $request->validate([
            'reaction' => 'required|in:like,love,haha,wow,sad,angry',
        ]);
        $reaction = PostReaction::updateOrCreate(
            [
                'post_id' => $postId,
                'user_id' => auth()->id(),
            ],
            [
                'reaction' => $validated['reaction'],
            ]
        );
        return response()->json($reaction, 201);
    }
    public function index($postId)
{
    $reactions = \App\Models\PostReaction::where('post_id', $postId)
        ->select('reaction', \DB::raw('count(*) as total'))
        ->groupBy('reaction')
        ->get();
    return response()->json($reactions);
}
}