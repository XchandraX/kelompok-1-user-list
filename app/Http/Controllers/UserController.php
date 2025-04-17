<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //untuk menampilkan halaman daftar user.
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //untuk menampilkan halaman create(tambah data)
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //untuk menangani proses menambahkan user baru ke table - bila
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()
            ->route('user.index')
            ->with('message', 'New user created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // untuk menampilkan halaman edit 
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // untuk menangani proses mengubah user lama menjadi user baru
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if (! empty($request->get('password'))) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('message', 'User updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // untuk menghapus data - niken
        $user->delete();
        return redirect()
            ->route('user.index')
            ->with('message', 'User deleted successfully');
    }
}
