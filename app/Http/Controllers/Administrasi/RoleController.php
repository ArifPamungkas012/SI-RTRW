<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $roles = Role::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('label', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->paginate(15);

        return view('administrasi.roles.index', compact('roles', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:50',
            'label' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Role::create($request->all());

        return redirect()->route('administrasi.roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'label' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        // Name usually shouldn't be changed easily as it affects logic, 
        // but here we allow it if unique, or restrict it just to label.
        // For safety, let's only allow label & description update for now 
        // to prevent breaking 'admin' checks.

        $role->update($request->only(['label', 'description']));

        return redirect()->route('administrasi.roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        // Prevent deleting critical roles
        if (in_array($role->name, ['admin', 'warga', 'bendahara', 'ketua_rt'])) {
            return back()->with('error', 'Role default sistem tidak dapat dihapus.');
        }

        $role->delete();

        return redirect()->route('administrasi.roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
