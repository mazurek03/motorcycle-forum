<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Pobieramy posty z relacjami
        $query = Post::with(['user', 'category', 'comments.user']);

        // Wyszukiwanie po tytule lub treści
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

        // Statystyki dla Dashboardu
        $totalUsers = User::count();
        $totalPosts = Post::count();

        return view('dashboard', compact('posts', 'categories', 'totalUsers', 'totalPosts'));
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
        // Uprawnienia: Admin (role_id 1) lub właściciel
        if (Auth::user()->role_id === 1 || Auth::id() === $post->user_id) {
            $post->delete();
            return back()->with('success', 'Post usunięty.');
        }

        return back()->with('error', 'Brak uprawnień.');
    }
}