<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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