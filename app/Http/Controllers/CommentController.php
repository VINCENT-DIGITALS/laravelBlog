<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'post_id' => 'required|integer|exists:posts,id',
        'comment' => 'required|string|max:500',
    ]);

    Comment::create([
        'post_id' => $validated['post_id'],
        'user_id' => session('user_id'),
        'comment' => $validated['comment'],
    ]);

    return redirect()->back()->with('success', 'Your comment has been added.');
}

}
