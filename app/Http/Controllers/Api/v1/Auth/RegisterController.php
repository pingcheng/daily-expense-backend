<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Response\JsonResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class RegisterController extends ApiController
{
	public function register(Request $request): Response {
		$payload = $request->validate([
			'email' => 'required|email|unique:users,email',
			'name' => 'required|max:100',
			'password' => 'required|min:7|max:100',
		]);

		$user = new User();
		$user->fill([
			'email' => $payload['email'],
			'name' => $payload['name'],
			'password' => Hash::make($payload['password'])
		]);
		$user->save();

		return JsonResponse::ok(null, 'Registered!');
	}
}