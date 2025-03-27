<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
// use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;

/**
 *  class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    // protected $userRepository;
    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->userRepository = $userRepository;
    // }

    // public function paginate()
    // {
    //     $users = $this->userRepository->getAllPaginate();
    //     return $users;
    // }
    public function paginate($perPage = 20, $keyword = null)
    {
        $query = User::query();

        // Lọc theo từ khóa nếu có
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        // Phân trang
        $users = $query->paginate($perPage);
        return $users;
    }
}