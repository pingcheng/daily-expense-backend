<?php


namespace App\Http\Controllers\Api\v1\Record;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use App\Http\Response\PaginationResponse;
use App\Models\Record\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AuthorisedApiController
{
	public function get(): Response {
		$user = $this->getUser();
		$builder = $user->recordCategories()->paginate();

		return JsonResponse::ok(PaginationResponse::build($builder, fn(Category $category) => $category->outputModel()));
	}

	public function put(Request $request): Response {
		$payload = $request->validate([
			'name' => 'required|string|max:50',
			'type' => 'required|integer|in:0,1'
		]);

		$user = $this->getUser();
		$errors = new MessageBag();
		$exist = $user->recordCategories()
			->where('name', $payload['name'])
			->exists();

		if ($exist) {
			$errors->add('name', 'This category name already exists');
		}

		if ($errors->any()) {
			return JsonResponse::unprocessableEntity($errors->getMessages());
		}

		/** @var Category $category */
		$category = $user->recordCategories()->create([
			'name' => $payload['name'],
			'type' => (int) $payload['type']
		]);

		return JsonResponse::ok($category->outputModel());
	}

	/**
	 * @param int $categoryId
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(int $categoryId): Response {
		$user = $this->getUser();

		/** @var Category|null $category */
		$category = $user->recordCategories()->where('id', $categoryId)->first();

		if ($category === null) {
			return JsonResponse::badRequest(null, "Category {$categoryId} is not found");
		}

		if ($category->subCategories()->exists()) {
			return JsonResponse::badRequest(null, "This category still has sub-categories, please delete them before delete this one.");
		}

		$category->delete();

		return JsonResponse::ok(null, 'deleted');
	}

	public function patch(Request $request, int $categoryId): Response {
		$payload = $request->validate([
			'name' => 'required|string|max:50',
		]);

		$user = $this->getUser();
		/** @var Category $category */
		$category = $user->recordCategories()->where('id', $categoryId)->first();

		if ($category === null) {
			return JsonResponse::badRequest(null, "Category {$categoryId} is not found");
		}

		$existed = $user
			->recordCategories()
			->where('name', $payload['name'])
			->where('id', '<>', $categoryId)
			->exists();

		if ($existed) {
			$error = new MessageBag();
			$error->add('name', 'This name already exists');
			return JsonResponse::unprocessableEntity($error->getMessages());
		}

		$category->update(['name' => $payload['name']]);

		return JsonResponse::ok($category->outputModel());
	}
}