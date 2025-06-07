<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('register-account', [
            'title' => 'Accounts',
            'heading' => 'Akun Pengguna',
            'accounts' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|string|min:8|max:255|confirmed',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'no_kk' => 'required|string|min:16|max:16',
            'nik' => 'required|string|min:16|max:16',
            'role' => 'required|in:admin,karyawan'
        ]);

        $user = new User();
        $user->email = $request->email;
        // $user->password = bcrypt($request->password);
        $user->password = bcrypt('filearchive2025'); // set default password
        $user->name = $request->name;
        $user->date_of_birth = $request->date_of_birth;
        $user->address = $request->address;
        $user->no_kk = $request->no_kk;
        $user->nik = $request->nik;
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true]);
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
        // return view('accounts.edit', compact('accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Akun berhasil dihapus.');
    }
}
