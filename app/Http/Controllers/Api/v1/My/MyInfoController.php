<?php


namespace App\Http\Controllers\Api\v1\My;


use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Response\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MyInfoController extends ApiController
{

	public function __construct()
	{
		$this->middleware('auth:api');
	}

	/**
	 * Api Controller
	 *
	 * @return Response
	 */
	public function get(): Response
	{
		$user = Auth::user();

		if ($user === null) {
			return JsonResponse::notFound();
		}

		return JsonResponse::ok([
			'id' => $user->getId(),
			'email' => $user->getEmail(),
			'name' => $user->getName(),
			'avatar' => $user->getAvatar()
		]);
	}
}