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
            $query->where(function ($q) use ($request) {
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
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'no_kk' => 'required|string|min:16|max:16',
            'nik' => 'required|string|min:16|max:16',
            'role' => 'required|in:admin,karyawan'
        ]);

        try {
            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt('filearchive2025');
            $user->name = $request->name;
            $user->date_of_birth = $request->date_of_birth;
            $user->address = $request->address;
            $user->no_kk = $request->no_kk;
            $user->nik = $request->nik;
            $user->role = $request->role;
            $user->save();

            session()->flash('success', 'Akun berhasil ditambahkan');
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan akun'
            ], 500);
        }
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
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $account->user_id . ',user_id',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'no_kk' => 'required|string|min:16|max:16',
            'nik' => 'required|string|min:16|max:16',
            'role' => 'required|in:admin,karyawan'
        ]);

        try {
            $account->email = $request->email;
            $account->name = $request->name;
            $account->date_of_birth = $request->date_of_birth;
            $account->address = $request->address;
            $account->no_kk = $request->no_kk;
            $account->nik = $request->nik;
            $account->role = $request->role;
            $account->save();

            session()->flash('success', 'Akun berhasil diubah');
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil diubah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah akun'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        try {
            $account->delete(); // ini akan melakukan soft delete
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus akun'
            ], 500);
        }
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
            'new_password' => 'required',
            'new_password_confirmation' => 'required',
        ]);

        $user = auth()->user();

        // Cek password lama
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        // Cek panjang password baru
        if (strlen($request->new_password) < 6) {
            return back()->withErrors(['new_password' => 'Password baru minimal 6 karakter.']);
        }

        // Cek konfirmasi password baru
        if ($request->new_password !== $request->new_password_confirmation) {
            return back()->withErrors(['new_password_confirmation' => 'Konfirmasi password baru tidak sesuai.']);
        }

        // Cek password baru tidak boleh sama dengan lama
        if (\Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password berhasil diubah.');
    }
}
