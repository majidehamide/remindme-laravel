<?php

namespace App\Services\UserReminderService;

use App\Models\UserReminder;
use Illuminate\Http\Request;
use App\DataTransferObjects\StoreUserReminderDTO;

interface UserReminderServiceInterface 
{
    public function create(StoreUserReminderDTO $storeUserDTO): ?UserReminder;
    public function getById($id):?UserReminder;
    public function fetch(Request $request);
    public function update(StoreUserReminderDTO $storeUserDTO, UserReminder $userReminder):?UserReminder;
    public function delete(UserReminder $userReminder):void;
}
