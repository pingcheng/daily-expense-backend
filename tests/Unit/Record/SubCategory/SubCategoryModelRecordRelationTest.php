<?php


namespace Tests\Unit\Record\SubCategory;


use Tests\Unit\TestCase;

class SubCategoryModelRecordRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function sub_category_with_no_records_will_return_empty_collection(): void
	{
		$category = $this->createRecordSubCategory();
		self::assertEmpty($category->records);
	}

	/**
	 * @test
	 */
	public function sub_category_has_records_will_return_filled_collection(): void
	{
		$user = $this->createUser();
		$category = $this->createRecordSubCategory(['user_id' => $user->getId()]);
		$record1 = $this->createRecord([
			'user_id' => $user->getId(),
			'sub_category_id' => $category->id
		]);
		$record2 = $this->createRecord([
			'user_id' => $user->getId(),
			'sub_category_id' => $category->id
		]);

		self::assertCount(2, $category->records);
		self::assertTrue($category->records->contains('id', $record1->id));
		self::assertTrue($category->records->contains('id', $record2->id));
	}
}