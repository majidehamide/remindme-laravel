<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\DataTransferObjects\StoreUserDTO;
use App\Repositories\User\UserRepository;
use App\Services\UserService\UserService;
use App\Services\UserService\UserServiceInterface;


class UserServiceTest extends TestCase
{
    
    /**
     * A basic unit test example.
     */
    public function test_create_user(): void
    {
        $mockUserRepository = Mockery::mock(UserRepository::class)->makePartial();
        $userDTO = new StoreUserDTO(name:"majid", email:"majid@test.id",password:"123456");
        $demoUser = new User([
            "id" => 1,
            "name" => "Majid",
            "email" => "majid@test.id"
        ]);
        $mockUserRepository->shouldReceive('create')->once()->andReturn($demoUser);
        $userService = new UserService($mockUserRepository);
        $this->assertEquals($userService->create($userDTO), $demoUser);
    }

    public function test_get_user_by_email():void{
        $demoUser = new User([
            "id" => 1,
            "name" => "Majid",
            "email" => "majid@test.id"
        ]);
        $mockUserRepository = Mockery::mock(UserRepository::class)->makePartial();
        $mockUserRepository->shouldReceive('getByEmail')->once()->andReturn($demoUser);
        $userService = new UserService($mockUserRepository);
        $this->assertEquals($userService->getByEmail("majid@test.id"), $demoUser);
    }
}
