<?php

namespace App\Repositories;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 *  class UserService
 * @package App\Services
 */
class UserRepository implements UserRepositoryInterface
{
    public function getAllPaginate()
    {
        return User::paginate(15);
    }
}