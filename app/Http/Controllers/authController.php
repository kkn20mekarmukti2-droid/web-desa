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
            return redirect()->intended(route('dashboard'));
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }
    
    public function formlogin(){
        // Clear any existing session data to prevent CSRF issues
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Ensure fresh session for login form
        session()->regenerateToken();
        
        return view('auth.login');
    }
    
    public function refreshCsrf(Request $request) {
        if ($request->ajax()) {
            return response()->json([
                'token' => csrf_token()
            ]);
        }
        
        return response()->json(['error' => 'Invalid request'], 400);
    }
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.akun.manage-modern', compact('users'));
    }

    public function create()
    {
        return view('admin.akun.add-modern');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:SuperAdmin,Admin,Writer,Editor',
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

        return redirect()->route('akun.manage')->with('pesan', 'User baru berhasil dibuat');
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
            'role' => 'required|string|in:SuperAdmin,Admin,Writer,Editor',
        ]);
        
        if ($user->id === Auth::id()) {
            return redirect()->route('akun.manage')->with('error', 'Tidak Bisa Merubah Role Akun Sendiri');
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('akun.manage')->with('pesan', 'Update Role Berhasil.');
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'created_at' => $user->created_at->format('d M Y, H:i'),
                    'updated_at' => $user->updated_at->format('d M Y, H:i'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->id === Auth::id()) {
                return redirect()->route('akun.manage')->with('error', 'Tidak bisa mengedit akun sendiri');
            }
            
            return view('admin.akun.edit-modern', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('akun.manage')->with('error', 'User tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->id === Auth::id()) {
                return redirect()->route('akun.manage')->with('error', 'Tidak bisa mengupdate akun sendiri');
            }
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required|string|in:SuperAdmin,Admin,Writer,Editor',
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                                 ->withErrors($validator)
                                 ->withInput();
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            return redirect()->route('akun.manage')->with('pesan', 'User berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('akun.manage')->with('error', 'User tidak ditemukan');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('akun.manage')->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('akun.manage')->with('pesan', 'User berhasil dihapus.');
    }
}
