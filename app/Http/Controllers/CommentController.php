<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Dodano komentarz!');
    }

    public function destroy(Comment $comment)
    {
        // Admin lub właściciel komentarza może usuwać
        if (Auth::user()->role_id === 1 || Auth::id() === $comment->user_id) {
            $comment->delete();
            return back()->with('success', 'Komentarz usunięty.');
        }

        return back()->with('error', 'Brak uprawnień.');
    }
}