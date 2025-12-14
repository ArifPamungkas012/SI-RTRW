<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->q;

        $users = User::with(['warga', 'role'])
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        $roles = Role::orderBy('label')->get();
        $wargas = Warga::select('id', 'nama', 'nik')->orderBy('nama')->get();

        return view('administrasi.users.index', compact(
            'users',
            'roles',
            'wargas',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => [
                'required',
                'exists:warga,id',
                Rule::unique('users', 'warga_id')
            ],
            'username' => 'required|string|max:50|unique:users,username|alpha_dash',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $warga = Warga::findOrFail($request->warga_id);

        User::create([
            'username' => $request->username,
            'name' => $warga->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'warga_id' => $warga->id,
        ]);

        return redirect()
            ->route('administrasi.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'warga_id' => 'nullable|exists:warga,id',
        ]);

        $user->update([
            'role_id' => $request->role_id,
            'warga_id' => $request->warga_id,
        ]);

        return back()->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
