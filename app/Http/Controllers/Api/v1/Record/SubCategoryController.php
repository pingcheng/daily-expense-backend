<?php


namespace App\Http\Controllers\Api\v1\Record;


use App\Http\Controllers\Api\v1\AuthorisedApiController;
use App\Http\Response\JsonResponse;
use App\Http\Response\PaginationResponse;
use App\Models\Record\Category;
use App\Models\Record\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends AuthorisedApiController
{
	public function get(int $categoryId): Response {
		$user = $this->getUser();

		/** @var Category|null $category */
		$category = $user->recordCategories()->where('id', $categoryId)->first();

		if ($category === null) {
			return JsonResponse::badRequest("Category {$categoryId} is not found");
		}

		return JsonResponse::ok(PaginationResponse::build(
			$category->subCategories()->paginate(),
			fn(SubCategory $category) => [
				'id' => $category->id,
				'name' => $category->name,
			])
		);
	}

	public function put(Request $request, int $categoryId): Response {
		$payload = $request->validate([
			'name' => 'required|string|max:50',
		]);

		$user = $this->getUser();
		$errors = new MessageBag();

		/** @var Category $category */
		$category = $user->recordCategories()->where('id', $categoryId)->first();

		if ($category === null) {
			return JsonResponse::badRequest("Category with ID {$categoryId} is not found");
		}

		$exist = $category->subCategories()
			->where('name', $payload['name'])
			->exists();

		if ($exist) {
			$errors->add('name', 'This sub-category name already exists');
		}

		if ($errors->any()) {
			return JsonResponse::unprocessableEntity($errors->getMessages());
		}

		/** @var SubCategory $subCategory */
		$subCategory = $category->subCategories()->create([
			'user_id' => $user->getId(),
			'category_id' => $category->id,
			'name' => $payload['name'],
		]);

		return JsonResponse::ok([
			'id' => $subCategory->id,
			'name' => $subCategory->name,
		]);
	}

	public function patch(Request $request, int $subCategoryId): Response {
		$payload = $request->validate([
			'name' => 'required|string|max:50',
		]);

		$user = $this->getUser();
		/** @var SubCategory|null $subCategory */
		$subCategory = $user->recordSubCategories()->where('id', $subCategoryId)->first();

		if ($subCategory === null) {
			return JsonResponse::badRequest(null, $this->subCategoryNotFound($subCategoryId));
		}

		$existed = $subCategory
			->category
			->subCategories()
			->where('name', $payload['name'])
			->where('id', '<>', $subCategoryId)
			->exists();

		if ($existed) {
			return JsonResponse::badRequest(null, "Sub-category name {$payload['name']} is already existed");
		}

		$subCategory->update([
			'name' => $payload['name']
		]);

		return JsonResponse::ok([
			'id' => $subCategory->id,
			'name' => $subCategory->name,
		]);
	}

	public function delete(Request $request, int $subCategoryId): Response {
		$user = $this->getUser();

		/** @var SubCategory $subCategory */
		$subCategory = $user->recordSubCategories()->where('id', $subCategoryId)->first();

		if ($subCategory === null) {
			return JsonResponse::badRequest(null, "Sub-Category {$subCategoryId} is not found");
		}

		if ($subCategory->records()->exists()) {
			return JsonResponse::badRequest(null, 'There are some records are still using this sub-category, please edit them to another sub-category before delete this.');
		}

		$subCategory->delete();

		return JsonResponse::ok(null, 'deleted');
	}

	private function subCategoryNotFound(int $id): string {
		return "Sub-category with ID ({$id}) is not found";
	}
}