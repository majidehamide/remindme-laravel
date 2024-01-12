<?php

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class LoginUserDTO extends DataTransferObject
{
    public string $email;
    public string $password;
}
