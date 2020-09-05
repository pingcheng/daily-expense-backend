<?php

namespace App\Exceptions;

use App\Exceptions\Oauth\MissingOauthClientException;
use App\Http\Response\JsonResponse;
use App\Models\Response\ApiResponse;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     *
     * @return Response
     *
	 * @throws Throwable
     */
    public function render($request, Throwable $exception): Response
    {

    	switch (get_class($exception)) {
			case NotFoundHttpException::class:
				return JsonResponse::notFound();

			case MethodNotAllowedHttpException::class:
				return JsonResponse::methodNotAllowed();

			case ValidationException::class:
				/** @var ValidationException $exception */
				return JsonResponse::unprocessableEntity($exception->errors(), $exception->getMessage());

			case MissingOauthClientException::class:
				return JsonResponse::internalServerError(null, $exception->getMessage());

			case UnauthorizedHttpException::class:
			case AuthenticationException::class:
				return JsonResponse::toResponse(new ApiResponse(401, $exception->getMessage(), null));
		}

        return JsonResponse::toResponse(new ApiResponse(500, $exception->getMessage(), $exception->getTrace()));
    }
}
