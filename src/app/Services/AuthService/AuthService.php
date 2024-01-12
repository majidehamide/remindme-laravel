<?php

namespace App\Services\AuthService;

use App\DataTransferObjects\LoginUserDTO;
use App\Models\User;
use App\Enums\AuthEnum;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function isAuthAttemptValid(LoginUserDTO $login) : bool{
        return Auth::attempt($login->toArray());
    }
    
    public function createAccessToken(User $user) : string {
        return $user->createToken(
            AuthEnum::AUTH_TOKEN_NAME,[AuthEnum::AUTH_TOKEN_ABILITY], 
            now()->addMinutes(AuthEnum::TOKEN_MINUTES_EXPIRED)
        )->plainTextToken;
    }

    public function createRefreshToken(User $user) : string {
        return $user->createToken(
            AuthEnum::REFRESH_TOKEN_NAME,[AuthEnum::REFRESH_TOKEN_ABILITY], 
            now()->addWeek()
        )->plainTextToken;
    }

    public function isAuthHasRefreshToken(User $user) : bool{
        return $user->tokenCan(AuthEnum::REFRESH_TOKEN_ABILITY);
    }

    public function isAuthHasAccessToken(User $user) : bool{
        return $user->tokenCan(AuthEnum::AUTH_TOKEN_ABILITY);
    }
}
