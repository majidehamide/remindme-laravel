<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if($request->expectsJson()){
            return JsonResponseHelper::unauthorizedError();
        }else{
            return route('/');
        } 
    }

    protected function unauthenticated($request, array $guards)
    {
         return JsonResponseHelper::unauthorizedError();
    }
}
