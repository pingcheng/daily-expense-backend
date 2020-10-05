<?php


namespace App\Http\Controllers\Api\v1\Record;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use App\Http\Response\PaginationResponse;
use App\Models\Record\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
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

	public function put(Request $request): Response {
		$user = $this->getUser();
		$payload = $request->validate([
			'description' => 'required|string|max:255',
			'subcategoryId' => 'required|integer|min:1',
			'amount' => 'required|integer|min:0',
			'datetime' => 'required|date',
		]);

		$errors = new MessageBag();

		if (!$user->recordSubCategories()->where('id', $payload['subcategoryId'])->exists()) {
			$errors->add('subcategoryId', 'You don\'t have this sub category');
		}

		if ($errors->any()) {
			return JsonResponse::unprocessableEntity($errors->getMessages());
		}

		$record = new Record();
		$record->fill([
			'sub_category_id' => $payload['subcategoryId'],
			'description' => $payload['description'],
			'amount' => (int) $payload['amount'],
			'user_id' => $user->id,
			'datetime' => Carbon::parse($payload['datetime']),
		]);
		$record->save();

		return JsonResponse::ok($record->outputModel(), 'Created');
	}
}