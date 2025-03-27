<?php

namespace App\Services\Interfaces;

/**
 *  Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserServiceInterface
{
    public function paginate($perpage = 20, $keyword = null);
}