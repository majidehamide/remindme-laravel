<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\UserReminder;
use App\DataTransferObjects\StoreUserReminderDTO;
use App\Repositories\UserReminder\UserReminderRepository;
use App\Services\UserReminderService\UserReminderService;
use Illuminate\Http\Request;

class UserReminderServiceTest extends TestCase
{
    private $userReminderDTOFaker;
    private $userReminderModelFaker;
    private $mockUserRepository;
    public function setUp(): void
    {
        parent::setUp();
        $this->userReminderDTOFaker = new StoreUserReminderDTO(title:"title", description:"description",remind_at:1704432379, event_at:1704432379, user_id:1);
        $this->userReminderModelFaker = new UserReminder([
            "id" => 1,
            "user_id"=>1,
            "title"=>"title",
            "description"=>"description",
            "remind_at"=>1704432379,
            "event_at"=>1704432379
        ]);
        $this->mockUserRepository = Mockery::mock(UserReminderRepository::class)->makePartial();
    }
    /**
     * A basic unit test example.
     */
    public function test_create_user_reminder(): void
    {
        $this->mockUserRepository->shouldReceive('create')->once()->andReturn($this->userReminderModelFaker);
        $userService = new UserReminderService($this->mockUserRepository);
        $this->assertEquals($userService->create($this->userReminderDTOFaker), $this->userReminderModelFaker);
    }

    public function test_get_by_id_user_reminder(): void
    {
        $this->mockUserRepository->shouldReceive('getById')->once()->andReturn($this->userReminderModelFaker);
        $userService = new UserReminderService($this->mockUserRepository);
        $this->assertEquals($userService->getById(1), $this->userReminderModelFaker);
    }

    public function test_fetch_user_reminder(): void
    {
        $this->mockUserRepository->shouldReceive('getAll')->once()->andReturn($this->userReminderModelFaker);
        $userService = new UserReminderService($this->mockUserRepository);
        $mockRequest = Mockery::mock(Request::class)->makePartial();
        $this->assertEquals($userService->fetch($mockRequest), $this->userReminderModelFaker);
    }

    public function test_update_user_reminder(): void
    {
        $this->mockUserRepository->shouldReceive('update')->once()->andReturn($this->userReminderModelFaker);
        $userService = new UserReminderService($this->mockUserRepository);
        $this->assertEquals($userService->update($this->userReminderDTOFaker, $this->userReminderModelFaker), $this->userReminderModelFaker);
    }

    public function test_delete_user_reminder(): void
    {
        $this->mockUserRepository->shouldReceive('delete')->once()->andReturn(null);
        $userService = new UserReminderService($this->mockUserRepository);
        $this->assertNull($userService->delete($this->userReminderModelFaker));
    }
}
