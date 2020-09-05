<?php


namespace Tests\Unit\Record\Category;


use Tests\Unit\TestCase;

class CategoryModelSubCategoriesRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function a_category_has_no_sub_categories_will_return_empty_collection(): void
	{
		$cat = $this->createRecordCategory();
		self::assertEmpty($cat->subCategories);
	}

	/**
	 * @test
	 */
	public function a_category_has_sub_categories_will_return_filled_collection(): void
	{
		$user = $this->createUser();
		$cat = $this->createRecordCategory(['user_id' => $user->getId()]);
		$subCat1 = $this->createRecordSubCategory([
			'user_id' => $user->getId(),
			'category_id' => $cat->id,
		]);
		$subCat2 = $this->createRecordSubCategory([
			'user_id' => $user->getId(),
			'category_id' => $cat->id,
		]);

		self::assertCount(2, $cat->subCategories);
		self::assertTrue($cat->subCategories->contains('id', $subCat1->id));
		self::assertTrue($cat->subCategories->contains('id', $subCat2->id));
	}

	/**
	 * @test
	 */
	public function sub_categories_wont_return_other_users(): void
	{
		$user = $this->createUser();
		$cat = $this->createRecordCategory(['user_id' => $user->getId()]);
		$subCat1 = $this->createRecordSubCategory([
			'user_id' => $user->getId(),
			'category_id' => $cat->id,
		]);
		$subCat2 = $this->createRecordSubCategory([
			'user_id' => $user->getId(),
			'category_id' => $cat->id,
		]);
		$subCat3 = $this->createRecordSubCategory([
			'user_id' => 3,
			'category_id' => $cat->id,
		]);

		self::assertCount(2, $cat->subCategories);
		self::assertTrue($cat->subCategories->contains('id', $subCat1->id));
		self::assertTrue($cat->subCategories->contains('id', $subCat2->id));
		self::assertFalse($cat->subCategories->contains('id', $subCat3->id));
	}
}