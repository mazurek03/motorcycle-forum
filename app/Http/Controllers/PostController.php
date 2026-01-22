<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        // Pobieramy posty z relacjami (Eager Loading zapobiega problemowi N+1)
        $query = Post::with(['user', 'category', 'comments.user']);

        // Wyszukiwanie
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('content', 'like', $searchTerm);
            });
        }

        // Filtrowanie po kategorii
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->latest()->get();
        $categories = Category::all();

        // Statystyki
        $totalUsers = User::count();
        $totalPosts = Post::count();

        return view('dashboard', compact('posts', 'categories', 'totalUsers', 'totalPosts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Post został dodany!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Sprawdzamy uprawnienia
        if ($user && ($user->role_id === 1 || $user->id === $post->user_id)) {
            $post->delete();
            return back()->with('success', 'Post usunięty.');
        }

        return back()->with('error', 'Brak uprawnień.');
    }
}