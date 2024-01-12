<?php

namespace App\DataTransferObjects;

use Ramsey\Uuid\Type\Integer;
use Spatie\DataTransferObject\DataTransferObject;

class StoreUserReminderDTO extends DataTransferObject
{
    public int $user_id;
    public string $title;
    public string $description;
    public string $remind_at;
    public string $event_at;
}
