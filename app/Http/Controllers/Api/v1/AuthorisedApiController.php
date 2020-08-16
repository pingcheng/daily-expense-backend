<?php


namespace App\Http\Controllers\Api\v1;


use App\User;
use Illuminate\Support\Facades\Auth;

class AuthorisedApiController extends ApiController
{
	public function __construct() {
		$this->middleware('auth:api');
	}

	/**
	 * Get current logged in user.
	 *
	 * @return User
	 */
	public function getUser(): User {
		return Auth::user();
	}
}