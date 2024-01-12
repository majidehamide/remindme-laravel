<?php

namespace App\Repositories\UserReminder;

use App\Models\UserReminder;
use Illuminate\Http\Request;

interface UserReminderRepositoryInterface
{
    public function getById($id): ?UserReminder;

    public function getAll(Request $request);

    public function create($data): ?UserReminder;

    public function update($id, UserReminder $userReminder): ?UserReminder;

    public function delete(UserReminder $userReminder) : void;
}
