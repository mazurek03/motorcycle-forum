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

        return back()->with('success', 'Komentarz dodany!');
    }

    public function destroy(Comment $comment)
    {
        // Sprawdzamy czy użytkownik jest autorem LUB ma rolę Admina(1) LUB Pracownika(2)
        if (Auth::id() === $comment->user_id || in_array(Auth::user()->role_id, [1, 2])) {
            $comment->delete();
            return back()->with('success', 'Komentarz został usunięty przez moderatora.');
        }

        return back()->with('error', 'Brak uprawnień do usunięcia tego komentarza.');
    }
}