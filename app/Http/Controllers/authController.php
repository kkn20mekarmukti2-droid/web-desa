<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class authController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }
    public function formlogin(){
        return view('auth.login');
    }
    public function index()
    {
        $users = User::where('id', '!=', 1)->get();
        return view('admin.akun.manage', compact('users'));
    }

    public function create()
    {
        return view('admin.akun.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->route('akun.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('akun.manage')->with('pesan', 'User baru Berhasil dibuat');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('akun.manage')->with('pesan', 'Password berhasil direset.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|integer|in:0,1',
        ]);
        if ($user->id === Auth::id()) {
            return redirect()->route('akun.manage')->with('error', 'Tidak Bisa Merubah Role Akun Sendiri');
        };

        $user->role = $request->role;
        $user->save();

        return redirect()->route('akun.manage')->with('pesan', 'Update Role Berhasil.');
    }
}
