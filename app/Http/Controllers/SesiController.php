<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SesiController extends Controller
{
    public function create(Request $request)
    {
        return $request->session()->has('bps_username')
            ? redirect()->route('home')
            : view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string'],
        ]);
        $user = User::find($credentials['username']);
        $storedPassword = (string) ($user?->password ?? '');
        $isHashedPassword = password_get_info($storedPassword)['algo'] !== null;
        $isValidPassword = $isHashedPassword
            ? Hash::check($credentials['password'], $storedPassword)
            : hash_equals($storedPassword, $credentials['password']);

        if (! $user || ! $isValidPassword) {
            return back()->withErrors(['username' => 'Username atau password salah.'])->onlyInput('username');
        }

        if (! $isHashedPassword || Hash::needsRehash($storedPassword)) {
            $user->update(['password' => Hash::make($credentials['password'])]);
        }

        $request->session()->regenerate();
        $request->session()->put('bps_username', $user->username);
        $request->session()->put('bps_last_activity', now());

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
