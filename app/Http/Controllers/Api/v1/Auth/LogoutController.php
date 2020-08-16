<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends AuthorisedApiController
{
	public function logout(Request $request): Response {
		$user = $this->getUser();
		$token = $user->token();

		if ($token) {
			$token->forceDelete();
		}

		$request->headers->remove('X-Refresh-Token');

		return JsonResponse::ok();
	}
}