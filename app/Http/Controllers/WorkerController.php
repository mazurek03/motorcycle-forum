<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'comments'])->latest()->get();
        $totalUsers = User::count();
        $totalPosts = Post::count();
        
        // Pobieramy wszystkich oprócz aktualnie zalogowanego Admina
        $clients = User::where('id', '!=', Auth::id())->get();
        
        return view('worker.dashboard', compact('posts', 'totalUsers', 'totalPosts', 'clients'));
    }

    public function banUser(Request $request, User $user)
    {
        // 1. Walidacja
        $request->validate(['days' => 'required|integer|min:1']);
        
        // 2. Naprawa błędu: rzutowanie $request->days na liczbę całkowitą (int)
        $user->update([
            'banned_until' => Carbon::now()->addDays((int) $request->days)
        ]);

        return back()->with('success', "Zaktualizowano status blokady dla {$user->name}.");
    }

    public function changeRole(Request $request, User $user)
    {
        // Tylko Admin może to robić
        if (Auth::user()->role_id !== 1) {
            return back()->with('error', 'Brak wystarczających uprawnień.');
        }

        // Walidacja: akceptujemy tylko ID 2 (Worker) lub 3 (Klient)
        $request->validate([
            'role_id' => 'required|in:2,3'
        ]);

        $user->update([
            'role_id' => $request->role_id
        ]);

        return back()->with('success', "Pomyślnie zmieniono uprawnienia użytkownika {$user->name}.");
    }
}