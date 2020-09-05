<?php


namespace Tests\Unit\Record\SubCategory;


use Tests\Unit\TestCase;

class SubCategoryModelCategoryRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function sub_category_should_have_a_main_category(): void
	{
		$user = $this->createUser();
		$category = $this->createRecordCategory(['user_id' => $user->getId()]);
		$sub = $this->createRecordSubCategory([
			'user_id' => $user->getId(),
			'category_id' => $category->id
		]);

		self::assertNotNull($sub->category);
		self::assertEquals($category->id, $sub->category->id);
	}

	/**
	 * @test
	 */
	public function broken_category_link_will_return_null(): void
	{
		$user = $this->createUser();
		$category = $this->createRecordCategory(['user_id' => $user->getId()]);
		$sub = $this->createRecordSubCategory([
			'user_id' => $user->getId(),
			'category_id' => $category->id + 1
		]);

		self::assertNull($sub->category);
	}
}