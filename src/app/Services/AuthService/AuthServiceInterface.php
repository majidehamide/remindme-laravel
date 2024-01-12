<?php

namespace App\Services\AuthService;

use App\Models\User;
use App\DataTransferObjects\LoginUserDTO;

interface AuthServiceInterface
{
    public function isAuthAttemptValid(LoginUserDTO $login) : bool;
    public function createAccessToken(User $user) : string ;
    public function createRefreshToken(User $user) : string ;
    public function isAuthHasRefreshToken(User $user) : bool;
    public function isAuthHasAccessToken(User $user) : bool;
}
