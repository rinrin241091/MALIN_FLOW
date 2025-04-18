<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller 
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //Dashboard
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('view user'))
        {
            abort(403, 'Unauthorized action.');
        }
        try {
            $perPage = $request->input('perpage', 20);
            $keyword = $request->input('keyword');
            $userCatalogueId = $request->input('user_catalogue_id', 0);
    
            $users = $this->userService->paginate($perPage, $keyword, $userCatalogueId);
            $users->appends($request->query());
    
            $config = $this->config();
            $template = 'backend.user.index';
            return view('backend.dashboard.layout', compact(
                'template',
                'config',
                'users'
            ));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.index')->with('error', 'Đã xảy ra lỗi khi lấy danh sách thành viên: ' . $e->getMessage());
        }
    }
    private function config()
    {
        return [
            'js' =>[
                'backend/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css'
            ]
        ];
    }

    //Active users
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|boolean', // Kiểm tra giá trị là boolean (0 hoặc 1)
        ]);

        $user = User::find($request->user_id);
        $user->status = (bool) $request->status; // Chuyển thành boolean
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }

    //Hiển thị form thêm thành viên
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('add user')) 
        {
            abort(403, 'Unauthorized action.');
        }
        $config = $this->config();
        $template = 'backend.user.addUser';
        return view('backend.dashboard.layout', compact(
            'template',
            'config'
        ));
    }
    //Xử lý thêm thành viên
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('add user')) 
        {
            abort(403, 'Unauthorized action.');
        }
        //validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ]);

        try {
            DB::beginTransaction();
            
            //Tạo người dùng mới
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = $validated['password']; // Model sẽ tự động thêm salt và mã hóa
            $user->address = $validated['address'];

            // Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists(public_path('avatars'))) {
                    mkdir(public_path('avatars'), 0775, true);
                }
                $file->move(public_path('avatars'), $filename);
                $user->image = 'avatars/' . $filename;
            }

            $user->save();
            
            // Gán role "user" cho người dùng mới
            $user->assignRole('user');

            DB::commit();

            return redirect()->route('user.index')
                ->with('success', 'Thêm thành viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi thêm thành viên: ' . $e->getMessage());
        }
    }

    //Hiển thị form Edit
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('edit user')) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Thành viên không tồn tại');
        }
        $config = $this->config();
        $template = 'backend.user.update';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'user'
        ));
    }
    //Xử lý Edit
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('edit user')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ]);

        try {
            $user = User::findOrFail($id);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->address = $validated['address'];

            if ($request->filled('password')) {
                $user->password = $validated['password']; // Model sẽ tự động thêm salt và mã hóa
            }

            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists(public_path('avatars'))) {
                    mkdir(public_path('avatars'), 0775, true);
                }
                $file->move(public_path('avatars'), $filename);
                $user->image = 'avatars/' . $filename; // Bỏ dấu / ở đầu
            }

            $user->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật thành viên thành công'
                ]);
            }

            return redirect()->route('user.index')
                ->with('success', 'Cập nhật thành viên thành công');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã xảy ra lỗi khi cập nhật thành viên: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật thành viên: ' . $e->getMessage());
        }
    }

    //Xử lý xóa thành viên
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('delete user')) 
        {
            abort(403, 'Unauthorized action.');
        }
    
        $user = User::find($id);
        if (!$user) 
        {
            return redirect()->route('user.index')->with('error', 'Thành viên không tồn tại');
        }
    
        // Ngăn xóa tài khoản admin
        if ($user->is_admin) 
        {
            return redirect()->route('user.index')->with('error', 'Không thể xóa tài khoản admin.');
        }
        
        // Xóa ảnh nếu có
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'Thành viên đã được xóa');
    }

    public function settings()
    {
        if (!auth()->user()->hasPermissionTo('view settings')) 
        {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        return view('backend.user.profiles.settingProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('update profile')) 
        {
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
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0775, true);
            }
            $file->move(public_path('avatars'), $filename);
            $user->image = 'avatars/' . $filename; // Bỏ dấu / ở đầu
        }

        $user->save();

        return redirect()->route('settings')->with('success', __('Thông tin đã được cập nhật thành công!'));
    }

    public function changePassword(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('change password')) 
        {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp'
        ]);

        $salt = env('PASSWORD_SALT', 'your-secret-salt');
        // Kiểm tra mật khẩu hiện tại với salt
        if (md5($request->current_password . $salt) !== $user->password) 
        {
            return redirect()->route('settings')
                ->with('error', 'Mật khẩu hiện tại không đúng');
        }

        // Cập nhật mật khẩu mới với salt
        $user->password = $request->password; // Model sẽ tự động thêm salt và mã hóa
        $user->save();

        return redirect()->route('settings')
            ->with('success', 'Mật khẩu đã được thay đổi thành công');
    }

    public function changeLanguage(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('change language')) 
        {
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
        if (!auth()->user()->hasPermissionTo('update privacy')) 
        {
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
        if (!auth()->user()->hasPermissionTo('delete user')) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $userIds = $request->input('user_ids', []);

        if (empty($userIds)) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn ít nhất một thành viên để xóa.'
            ], 400);
        }

        try {
            DB::beginTransaction();
            
            // Kiểm tra xem có admin trong danh sách không
            $hasAdmin = User::whereIn('id', $userIds)
                           ->where('is_admin', true)
                           ->exists();
            
            if ($hasAdmin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản admin.'
                ], 400);
            }

            // Xóa ảnh của các thành viên được chọn
            $users = User::whereIn('id', $userIds)->get();
            foreach ($users as $user) {
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
            }

            // Xóa các thành viên được chọn
            $deleted = User::whereIn('id', $userIds)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ' . count($userIds) . ' thành viên thành công.',
                'deleted_count' => $deleted
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk delete error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa thành viên: ' . $e->getMessage()
            ], 500);
        }
    }

    
}
