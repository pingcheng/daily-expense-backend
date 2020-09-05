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
			fn(Record $item) => [
				'id' => $item->id,
				'description' => $item->description,
				'amount' => $item->amount,
				'datetime' => $item->datetime,
				'subCategory' => [
					'id' => $item->subCategory->id ?? null,
					'name' => $item->subCategory->name ?? null,
				],
				'category' => [
					'id' => $item->subCategory->category->id ?? null,
					'name' => $item->subCategory->category->name ?? null,
					'type' => $item->subCategory->category->type ?? null,
				]
			]
		));
	}
}