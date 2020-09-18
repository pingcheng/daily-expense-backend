<?php


namespace App\Http\Controllers\Api\v1\Record;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use App\Http\Response\PaginationResponse;
use App\Models\Record\Record;
use Symfony\Component\HttpFoundation\Response;

class RecordsController extends AuthorisedApiController
{
	public function get(): Response {
		$user = $this->getUser();

		$builder = $user->records()
			->with(['subCategory', 'subCategory.category'])
			->paginate($this->getPerPage());

		return JsonResponse::ok(PaginationResponse::build(
			$builder,
			fn(Record $item) => $item->outputModel()
		));
	}
}