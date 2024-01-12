<?php

namespace App\Exceptions;

use Throwable;
use App\Enums\ErrorType;
use App\Enums\ErrorMessage;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Route not found.'
                ], 404);
            }
        });
        $this->renderable(function (\Exception $e, Request $request) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
            return JsonResponseHelper::internalError(ErrorType::INTERNAL_ERROR_TYPE, ErrorMessage::INTERNAL_ERROR_MESSAGE);
        });
        
        
    }
}
