<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter Urutan
        $order = $request->input('order', 'desc'); // default terbaru
        $query->orderBy('created_at', $order);

        // Untuk mobile dan desktop, tetap gunakan pagination berbeda
        return view('register-account', [
            'title' => 'Accounts',
            'heading' => 'Akun Pengguna',
            'accountsMobile' => $query->clone()->paginate(5)->appends($request->all()),
            'accountsDesktop' => $query->paginate(10)->appends($request->all()),
            'search' => $request->search,
            'role' => $request->role,
            'order' => $order,
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
    public function edit(User $account)
    {
        return view('accounts.edit', compact('accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $account)
    {
        logger($account);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $account->user_id . ',user_id',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'no_kk' => 'required|string|min:16|max:16',
            'nik' => 'required|string|min:16|max:16',
            'role' => 'required|in:admin,karyawan'
        ]);

        $account->email = $request->email;
        $account->name = $request->name;
        $account->date_of_birth = $request->date_of_birth;
        $account->address = $request->address;
        $account->no_kk = $request->no_kk;
        $account->nik = $request->nik;
        $account->role = $request->role;
        $account->save();

        return redirect()->route('accounts.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Akun berhasil dihapus.');
    }

    /**
     * Update the authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // 2MB
        ], [
            'photo.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;

        // Handle upload photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();

            $destination = public_path('images/profiles');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            // Hapus foto lama jika ada dan bukan default
            if ($user->p_profile && file_exists($destination . '/' . $user->p_profile)) {
                @unlink($destination . '/' . $user->p_profile);
            }

            $user->p_profile = $filename;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password berhasil diubah.');
    }
}
