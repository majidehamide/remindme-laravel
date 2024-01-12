<?php

namespace App\Helpers;

use App\Enums\ErrorMessage;
use App\Enums\ErrorType;
use App\Enums\HttpStatus;

class JsonResponseHelper
{
    public static function successRegister($user){
        return response()->json([
            "success" =>true,
            "user" => $user
        ], HttpStatus::SUCCESS);
    }

    public static function internalError($errorType, $errorMessage){
        return response()->json([
                "ok"=> false,
                "err"=> $errorType,
                "msg"=> $errorMessage
        ], HttpStatus::INTERNAL_ERROR);
    }

    public static function unauthorizedErrorLogin(){
        return response()->json([
                "ok"=> false,
                "err"=> ErrorType::INVALID_CREDS_TYPE,
                "msg"=> ErrorMessage::INCORRECT_EMAIL_OR_PASSWORD
        ], HttpStatus::UNAUTHORIZED);
    }

    public static function unauthorizedError(){
        return response()->json([
                "ok"=> false,
                "err"=> ErrorType::INVALID_CREDS_TYPE,
                "msg"=> ErrorMessage::INVALID_CREDENTIAL
        ], HttpStatus::UNAUTHORIZED);
    }

    public static function successLogin($user, $accessToken, $refreshToken){
        return response()->json([
            "ok"=> true,
            "data"=> [
                "user"=> $user,
                "access_token"=> $accessToken,
                "refresh_token"=> $refreshToken
            ]
        ], HttpStatus::SUCCESS);
    }

    public static function successRefreshToken($accessToken){
        return response()->json([
            "ok"=> true,
            "data"=> [
                "access_token"=> $accessToken
            ]
        ], HttpStatus::SUCCESS);
    }

    public static function successResponse(){
        return response()->json([
            "ok"=> true
        ], HttpStatus::SUCCESS);
    }

    public static function successResponseWithData($data){
        return response()->json([
            "ok"=> true,
            "data"=> $data
        ], HttpStatus::SUCCESS);
    }

    
}
