<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $prodis = \App\Models\Prodi::orderBy('nama_prodi')->get();
        return view('auth.register', compact('prodis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'nim'       => ['required', 'string', 'max:20', 'unique:users,nim'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            'prodi_id'  => ['required', 'exists:prodi,id'],
            'angkatan'  => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y')],
            'no_hp'     => ['nullable', 'string', 'max:15'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'nim'      => $request->nim,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id'  => $user->id,
            'prodi_id' => $request->prodi_id,
            'angkatan' => $request->angkatan,
            'no_hp'    => $request->no_hp,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('mahasiswa.dashboard');
    }
}