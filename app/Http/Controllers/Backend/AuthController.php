<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
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
    
        if ($user && md5($credentials['password'] . $salt) === $user->password) 
        {
            // Kiểm tra trạng thái user
            if (!$user->status) { // status = false
                return redirect()->route('auth.admin')->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ admin để được hỗ trợ.');
            }

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
}
