<?php


namespace App\Http\Controllers\Api\v1\My;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends AuthorisedApiController
{
	public function get(): Response {
		$user = $this->getUser();
		return JsonResponse::ok([
			'id' => $user->getId(),
			'email' => $user->getEmail(),
			'name' => $user->getName(),
			'avatar' => $user->getAvatar()
		]);
	}

	public function update(Request $request): Response {
		$payload = $request->validate([
			'name' => 'required|string|min:7',
		]);

		$user = $this->getUser();

		$user->setName($payload['name']);
		$user->save();

		return JsonResponse::ok();
	}
}