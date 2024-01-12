<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Enums\AuthEnum;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\DataTransferObjects\LoginUserDTO;
use App\Services\AuthService\AuthService;
use Illuminate\Foundation\Testing\WithFaker;

class AuthServiceTest extends TestCase
{
    use WithFaker;
    private $authService;

    public function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService;
        
    }
    /**
     * A basic unit test example.
     */
    public function test_is_auth_attempt_is_valid(): void
    {
        $password = $this->faker->password();
        $email = $this->faker->freeEmail();
        $userDTO = new LoginUserDTO(email:$email,password:$password);
        Auth::shouldReceive('attempt')->once()->andReturn(true);
        $this->assertTrue($this->authService->isAuthAttemptValid($userDTO));
    }

    public function test_create_access_token(): void
    {
        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = Str::random(40),
            hash('crc32b', $tokenEntropy)
        );
        $personalAccessTokenFaker = new PersonalAccessToken([
            'name' => AuthEnum::AUTH_TOKEN_NAME,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => [AuthEnum::AUTH_TOKEN_ABILITY],
            'expires_at' => now()->addMinutes(AuthEnum::TOKEN_MINUTES_EXPIRED),
        ]);
        $mockNewAccessToken = Mockery::mock( NewAccessToken::class)->makePartial();
        $mockNewAccessToken->accessToken = $personalAccessTokenFaker;
        $mockNewAccessToken->plainTextToken = $personalAccessTokenFaker->getKey().'|'.$plainTextToken;
        $mockUser = Mockery::mock(User::class)->makePartial();
        $mockUser->shouldReceive('createToken')->once()->andReturn($mockNewAccessToken);
        $this->assertEquals($this->authService->createAccessToken($mockUser), $personalAccessTokenFaker->getKey().'|'.$plainTextToken);
    }

    public function test_create_refresh_token(): void
    {
        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = Str::random(40),
            hash('crc32b', $tokenEntropy)
        );
        $personalAccessTokenFaker = new PersonalAccessToken([
            'name' => AuthEnum::REFRESH_TOKEN_NAME,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => [AuthEnum::REFRESH_TOKEN_ABILITY],
            'expires_at' => now()->addMinutes(AuthEnum::TOKEN_MINUTES_EXPIRED),
        ]);
        $mockNewAccessToken = Mockery::mock( NewAccessToken::class)->makePartial();
        $mockNewAccessToken->accessToken = $personalAccessTokenFaker;
        $mockNewAccessToken->plainTextToken = $personalAccessTokenFaker->getKey().'|'.$plainTextToken;
        $mockUser = Mockery::mock(User::class)->makePartial();
        $mockUser->shouldReceive('createToken')->once()->andReturn($mockNewAccessToken);
        $this->assertEquals($this->authService->createAccessToken($mockUser), $personalAccessTokenFaker->getKey().'|'.$plainTextToken);
    }

    public function test_is_auth_has_refresh_token():void{
        $mockUser = Mockery::mock(new User)->makePartial();
        $mockUser->shouldReceive('tokenCan')->with(AuthEnum::REFRESH_TOKEN_ABILITY)->once()->andReturn(true);
        $this->assertTrue($this->authService->isAuthHasRefreshToken($mockUser));
    }

    public function test_is_auth_has_access_token():void{
        $mockUser = Mockery::mock(new User)->makePartial();
        $mockUser->shouldReceive('tokenCan')->with(AuthEnum::AUTH_TOKEN_ABILITY)->once()->andReturn(true);
        $this->assertTrue($this->authService->isAuthHasAccessToken($mockUser));
    }
}
