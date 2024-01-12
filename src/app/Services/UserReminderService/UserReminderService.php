<?php

namespace App\Services\UserReminderService;

use App\Models\UserReminder;
use Illuminate\Http\Request;
use App\DataTransferObjects\StoreUserReminderDTO;
use App\Repositories\UserReminder\UserReminderRepositoryInterface;

class UserReminderService implements UserReminderServiceInterface
{
    protected $userReminderRepository;
    
    public function __construct(UserReminderRepositoryInterface $userReminderRepository)
    {
        $this->userReminderRepository = $userReminderRepository;
    }
    public function create(StoreUserReminderDTO $storeUserDTO):?UserReminder{
        return $this->userReminderRepository->create($storeUserDTO->toArray());
    }
    public function getById($id):?UserReminder{
        return $this->userReminderRepository->getById($id);
    }

    public function fetch(Request $request){
        return $this->userReminderRepository->getAll($request);
    }

    public function update(StoreUserReminderDTO $storeUserDTO, UserReminder $userReminder):?UserReminder{
        return $this->userReminderRepository->update($storeUserDTO->toArray(), $userReminder);
    }

    public function delete(UserReminder $userReminder):void{
        $this->userReminderRepository->delete($userReminder);
    }
}
