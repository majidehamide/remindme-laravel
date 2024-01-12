<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\UserReminder;
use Illuminate\Http\Request;
use App\Mail\UserReminderEmail;
use App\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserReminderResource;
use App\Http\Requests\StoreUserReminderRequest;
use App\Jobs\UserReminderJob;
use App\Services\UserReminderService\UserReminderServiceInterface;

class UserReminderController extends Controller
{
    protected $userReminderService;

    public function __construct(UserReminderServiceInterface $userReminderService)
    {
        $this->userReminderService = $userReminderService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserReminderRequest $request)
    {
        $userReminder = $this->userReminderService->create($request->toDTO());
        $reminderTime = Carbon::createFromTimeStamp($userReminder->remind_at);
        UserReminderJob::dispatch($request->user(), $userReminder)->delay($reminderTime->addMinute());
        return JsonResponseHelper::successResponseWithData(new UserReminderResource($userReminder));
    }

    /**
     * Display the resource.
     */
    public function getListReminder(Request $request)
    {
        $userReminders = $this->userReminderService->fetch($request);
        $userReminders['reminders'] = UserReminderResource::collection( $userReminders['reminders']);
        return JsonResponseHelper::successResponseWithData($userReminders);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserReminder $userReminder)
    {
        return JsonResponseHelper::successResponseWithData(new UserReminderResource($userReminder));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserReminderRequest $request, UserReminder $userReminder)
    {
        $userReminder = $this->userReminderService->update($request->toDTO(),$userReminder);
        return JsonResponseHelper::successResponseWithData(new UserReminderResource($userReminder));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReminder $userReminder)
    {
        $userReminder = $this->userReminderService->delete($userReminder);
        return JsonResponseHelper::successResponse();
    }
}
