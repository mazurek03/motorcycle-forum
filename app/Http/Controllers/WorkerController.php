<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkerController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'comments'])->latest()->get();
        $totalUsers = User::count();
        $totalPosts = Post::count();
        // Pobieramy tylko zwykłych użytkowników (rola 3) do tabeli banowania
        $clients = User::where('role_id', 3)->get();
        
        return view('worker.dashboard', compact('posts', 'totalUsers', 'totalPosts', 'clients'));
    }

    public function banUser(Request $request, User $user)
    {
        $request->validate([
            'days' => 'required|integer|min:1'
        ]);

        // Ustawiamy datę wygaśnięcia bana
        $user->update([
            'banned_until' => Carbon::now()->addDays($request->days)
        ]);

        return back()->with('success', "Użytkownik {$user->name} został zbanowany na {$request->days} dni.");
    }
}