<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __contstruct()
    {

    }
    public function index()
    {
        if(Auth::id()>0)
            return redirect()->route('dashboard.index');
        return view('backend.auth.login'); 
    }
    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'), 
            'password' => $request->input('password')
        ];
    
        $user = User::where('email', $credentials['email'])->first();
        $salt = env('PASSWORD_SALT', 'your-secret-salt');
    
        if ($user && md5($credentials['password'] . $salt) === $user->password) {
            Auth::login($user);
    
            // Chuyển hướng dựa trên vai trò
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect()->route('backend.home')->with('success', 'Đăng nhập thành công');
            }
        }
    
        return redirect()->route('auth.admin')->with('error', 'Email hoặc mật khẩu không chính xác');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.admin');
    }
    public function register()
    {
        return view('backend.auth.register');   
    }
    public function registerStore(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);
        
        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        // Gán vai trò user
        $user->assignRole('user');
        
        $user->save();
        return redirect()->route('auth.register')->with('success', 'Đăng ký thành công');
    }
}
