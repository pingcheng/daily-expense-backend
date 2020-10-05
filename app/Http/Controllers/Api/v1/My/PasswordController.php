<?php


namespace App\Http\Controllers\Api\v1\My;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class PasswordController extends AuthorisedApiController
{
	public function update(Request $request): Response {
		$payload = $request->validate([
			'currentPassword' => 'required|string|min:7',
			'newPassword' => 'required|string|min:7',
		]);

		$user = $this->getUser();

		if (!Hash::check($payload['currentPassword'], $user->getPassword())) {
			return JsonResponse::unprocessableEntity([
				'currentPassword' => 'Wrong password.'
			]);
		}

		$user->setPassword($payload['newPassword']);
		$user->save();

		return JsonResponse::ok();
	}
}