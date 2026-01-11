<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\OpdMaster;

class UsersController extends Controller
{
    public function create(Request $request)
    {
        $roles = Role::query()->orderBy('name')->pluck('name')->all();
        $opds = OpdMaster::query()->orderBy('name')->get();
        return view('user.create', compact('roles', 'opds'));
    }

    public function index(Request $request, UsersService $service)
    {
        $q = (string) $request->query('q', '');
        $role = (string) $request->query('role', '');
        $status = (string) $request->query('status', '');
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;
        $users = $service->listUsers($q ?: null, $role ?: null, $status ?: null, $perPage);
        $stats = $service->getStats();
        $roles = Role::query()->orderBy('name')->pluck('name')->all();
        return view('user.index', compact('users', 'roles', 'q', 'role', 'status', 'stats'));
    }

    public function suggest(Request $request, UsersService $service)
    {
        $q = (string) $request->query('q', '');
        if ($q === '') {
            return response()->json(['data' => []]);
        }
        return response()->json(['data' => $service->suggestUsers($q)]);
    }

    public function store(Request $request, UsersService $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['nullable', 'in:active,pending,inactive'],
            'role' => ['nullable', 'string'],
            'opd_master_id' => ['nullable', 'exists:opd_masters,id'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:800'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);
        try {
            $service->createUser($validated, $request->file('photo'));
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::query()->orderBy('name')->pluck('name')->all();
        $opds = OpdMaster::query()->orderBy('name')->get();
        return view('user.edit', compact('user', 'roles', 'opds'));
    }

    public function update(Request $request, UsersService $service, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'status' => ['nullable', 'in:active,pending,inactive'],
            'role' => ['nullable', 'string'],
            'opd_master_id' => ['nullable', 'exists:opd_masters,id'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:800'],
            'remove_photo' => ['nullable', 'string', 'in:0,1'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);
        try {
            $service->updateUser($user, $validated, $request->file('photo'));
            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
