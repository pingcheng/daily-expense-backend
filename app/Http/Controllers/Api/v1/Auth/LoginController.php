<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Response\JsonResponse;
use App\Models\Auth\LoginCredential;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
	/**
	 * Api Controller
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function login(Request $request): Response
	{
		$payload = $request->validate([
			'email' => 'required|email|exists:users',
			'password' => 'required|min:7'
		]);

		$credential = new LoginCredential($payload['email'], $payload['password']);

		/** @var User $user */
		$user = User::where('email', $credential->getEmail())->first();

		if (!Hash::check($credential->getPassword(), $user->getPassword())) {
			return JsonResponse::unprocessableEntity([
				'password' => ['Wrong password.']
			]);
		}

		$token = $user->createToken('webapp', ['*']);

		$request->headers->remove('X-Refresh-Token');

		return JsonResponse::ok([
			'user' => [
				'id' => $user->getId(),
				'name' => $user->getName(),
			],
			'token' => [
				'accessToken' => $token->accessToken,
				'expires' => $token->token->expires_at,
			]
		],'success');
	}
}