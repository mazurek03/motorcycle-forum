<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // Pobieramy posty z relacjami, najnowsze na górze
        $posts = Post::with(['user', 'category'])->latest()->get();
        return view('dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Post został dodany!');
    }

    public function destroy(Post $post)
    {
        // Sprawdzenie uprawnień: Admin (role_id 1) lub właściciel posta
        if (Auth::user()->role_id === 1 || Auth::id() === $post->user_id) {
            $post->delete();
            return back()->with('success', 'Post usunięty pomyślnie.');
        }

        return back()->with('error', 'Nie masz uprawnień do usunięcia tego posta.');
    }
}