<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class HttpStatus
{
    const SUCCESS = 200;
    const UNPROCESSABLE_ENTITY = 422;
    const UNAUTHORIZED = 401;
    const INTERNAL_ERROR = 500;

}
