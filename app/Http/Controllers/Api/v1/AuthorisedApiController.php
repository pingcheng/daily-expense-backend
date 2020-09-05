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

	public function getPerPage(): ?int {
		if (!request()->has('perPage')) {
			return null;
		}

		$perPage = request()->get('perPage');
		$perPage = filter_var($perPage, FILTER_VALIDATE_INT);

		if ($perPage === false) {
			return null;
		}

		if ($perPage < 1) {
			return 1;
		}

		if ($perPage > 25) {
			return 25;
		}

		return (int) $perPage;
	}
}