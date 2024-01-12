<?php

namespace App\Services\UserService;

use App\DataTransferObjects\StoreUserDTO;
use App\Models\User;

interface UserServiceInterface
{
    public function create(StoreUserDTO $storeUserDTO): User;
    public function getByEmail($email): ?User;
}
