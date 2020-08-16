<?php


namespace App\Http\Response;


use App\Models\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponse
{
	public static function ok($payload = null, string $message = 'success'): Response {
		return self::toResponse(new ApiResponse(200, $message, $payload));
	}

	public static function badRequest($payload = null, string $message = 'Bad request'): Response {
		return self::toResponse(new ApiResponse(400, $message, $payload));
	}

	public static function notFound($payload = null, string $message = 'The API endpoint is not found'): Response {
		return self::toResponse(new ApiResponse(404, $message, $payload));
	}

	public static function methodNotAllowed($payload = null, string $message = 'The API endpoint method is not allowed'): Response {
		return self::toResponse(new ApiResponse(405, $message, $payload));
	}

	public static function unprocessableEntity($payload = null, string $message = 'Unprocessable entity found'): Response {
		return self::toResponse(new ApiResponse(422, $message, $payload));
	}

	public static function internalServerError($payload = null, string $message = 'Internal server error'): Response {
		return self::toResponse(new ApiResponse(500, $message, $payload));
	}

	public static function toResponse(ApiResponse $apiResponse): Response {
		return new Response($apiResponse->toJson(), $apiResponse->getStatusCode(), [
			'Content-Type' => 'application/json'
		]);
	}
}