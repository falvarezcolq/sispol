<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;


class UserController extends Controller
{
     public function index(Request $request)
    {
        // $this->authorize('viewAny', User::class);

        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 10);

        $users = User::when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'search' => $search !== '' ? $search : null,
        ]);
    }

    public function create()
    {
        // $this->authorize('create', User::class);
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        // $this->authorize('create', User::class);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(6)],
            'enabled'  => 'required|boolean',
            'is_admin' => 'required|boolean',

        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'enabled'    => $request->boolean('enabled', true),
            'is_admin'   => $request->boolean('is_admin', false),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        // $this->authorize('view', $user);

        return Inertia::render('Users/Show', [
            'user' => $user,
            'cards' => $user->cards()->orderByDesc('id')->get(),
        ]);
    }

    public function edit(User $user)
    {
        // $this->authorize('update', $user);

        return Inertia::render('Users/Edit', [
            'user'  => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        // $this->authorize('update', $user);

        $request->validate([
            'name'     => 'required|string|max:255',
       
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', Password::min(8)],
            'enabled'  => 'boolean',
            'is_admin' => 'boolean',
        ]);


          if ($user->id === auth()->id()) {
            if($request->boolean('enabled') === false) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'enabled' => 'No puedes deshabilitar tu propia cuenta.',
                ]);
            }
        }

        $user->update([
            'name'       => $request->name,
         
            'email'      => $request->email,
            'enabled'    => $request->boolean('enabled'),
            'is_admin'   => $request->boolean('is_admin'),
            'updated_by' => auth()->id(),
            ...($request->filled('password') ? ['password' => Hash::make($request->password)] : []),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        // $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->update(['deleted_by' => auth()->id()]);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

}
