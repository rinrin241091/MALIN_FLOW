<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Services\Interfaces\UserServiceInterface as UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\UserService;

class UserController extends Controller 
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('view user')){
            abort(403, 'Unauthorized action.');
        }
        // Lấy tham số từ request
        $perPage = $request->input('perpage', 20); // Mặc định 20 bản ghi mỗi trang
        $keyword = $request->input('keyword');
        
        // Lấy danh sách thành viên với tìm kiếm và phân trang
        $users = $this->userService->paginate($perPage, $keyword);

        $config = $this->config();
        $template = 'backend.user.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'users'
        ));
    }
    private function config(){
        return [
            'js' =>[
                'backend/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css'
            ]
        ];
    }

    //Hiển thị form thêm thành viên
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('add user')) {
            abort(403, 'Unauthorized action.');
        }
        return view('backend.user.addUser');
    }
    //Xử lý thêm thành viên
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('add user')) {
            abort(403, 'Unauthorized action.');
        }
        //validate input
        $validated = $request->validate([
            'name' =>'required',
            'email' =>'required|email|unique:users',
            'phone' =>'required',
            'password' =>'required|min:8|confirmed',
            'address' => 'required',
            'image' => 'required|image'
        ]);

        //Tạo người dùng mới
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->address = $request->address;

        //Xử lý up ảnh
        if($request->hasFile('image')){
            $path = $request->file('image')->store('avatars','public');
            $user->image = $path;
        }
        $user->save();
        return redirect()->route('user.index')->with('success','Thành viên đã được thêm');
    }

    //Hiển thị form Edit
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('edit user')) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::find($id);
        return view('backend.user.update', compact('user'));
    }
    //Xử lý Edit
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = User::findOrFail($id);
    
        if ($request->hasFile('image')) {
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }
            $path = $request->file('image')->store('public/users');
            $validated['image'] = str_replace('public/', '', $path);
        }
    
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }
    
        $user->update($validated);
    
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành viên thành công.'
            ]);
        }
    
        return redirect()->route('user.index')->with('success', 'Cập nhật thành viên thành công.');
    }

    //Xử lý xóa thành viên
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('delete user')) {
            abort(403, 'Unauthorized action.');
        }
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Thành viên không tồn tại');
        }
    
        // Ngăn xóa tài khoản admin
        if ($user->is_admin) {
            return redirect()->route('user.index')->with('error', 'Không thể xóa tài khoản admin.');
        }
    
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Thành viên đã được xóa');
    }

    public function settings()
    {
        if (!auth()->user()->hasPermissionTo('view settings')) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        return view('backend.user.profiles.settingProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('update profile')) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cập nhật thông tin
        $user->name = $request->name;
        $user->email = $request->email;

        // Xử lý upload ảnh đại diện
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($user->image) {
                Storage::delete('public/' . $user->image);
            }
            $path = $request->file('image')->store('public/avatars');
            $user->image = str_replace('public/', '', $path);
        }

        $user->save();

        return redirect()->route('settings')->with('success', __('Thông tin đã được cập nhật thành công!'));
    }

    public function changePassword(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('change password')) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (md5($request->current_password) !== $user->password) {
            return redirect()->route('settings')->with('error', __('Mật khẩu hiện tại không đúng.'));
        }

        // Cập nhật mật khẩu mới
        $user->password = $request->password;
        $user->save();

        return redirect()->route('settings')->with('success', __('Mật khẩu đã được thay đổi thành công!'));
    }

    public function changeLanguage(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('change language')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'language' => 'required|in:vi,en',
        ]);

        // Lưu ngôn ngữ vào session
        session(['locale' => $request->language]);

        // Cập nhật ngôn ngữ cho ứng dụng
        app()->setLocale($request->language);

        return redirect()->route('settings')->with('success', __('Ngôn ngữ đã được thay đổi thành công!'));
    }

    public function updatePrivacy(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('update privacy')) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();

        $validated = $request->validate([
            'receive_emails' => 'boolean',
        ]);

        $user->receive_emails = $request->has('receive_emails') ? 1 : 0;
        $user->save();

        return redirect()->route('settings')->with('success', __('Cài đặt quyền riêng tư đã được cập nhật!'));
    }

    //Xóa hàng loạt trong table của dashboard
    public function bulkDelete(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('delete user')) {
            abort(403, 'Unauthorized action.');
        }

        $userIds = $request->input('user_ids', []);

        if (empty($userIds)) {
            return redirect()->route('user.index')->with('error', 'Vui lòng chọn ít nhất một thành viên để xóa.');
        }

        // Xóa các thành viên được chọn
        User::whereIn('id', $userIds)->delete();

        return redirect()->route('user.index')->with('success', 'Đã xóa các thành viên được chọn.');
    }
}
