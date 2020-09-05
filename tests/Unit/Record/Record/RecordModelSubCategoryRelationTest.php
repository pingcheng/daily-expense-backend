<?php


namespace Tests\Unit\Record\Record;


use Tests\Unit\TestCase;

class RecordModelSubCategoryRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function a_record_should_have_a_sub_category(): void
	{
		$subCategory = $this->createRecordSubCategory();
		$record = $this->createRecord(['sub_category_id' => $subCategory->id]);
		self::assertNotNull($record->subCategory);
		self::assertEquals($subCategory->id, $record->subCategory->id);
	}

	/**
	 * @test
	 */
	public function broken_sub_category_relation_will_return_null(): void
	{
		$record = $this->createRecord();
		self::assertNull($record->subCategory);
	}
}