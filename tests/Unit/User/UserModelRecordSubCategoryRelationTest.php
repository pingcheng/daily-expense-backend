<?php


namespace Tests\Unit\User;


use Tests\Unit\TestCase;

class UserModelRecordSubCategoryRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function a_user_does_not_have_record_sub_categories_will_return_empty_collection(): void
	{
		$user = $this->createUser();
		self::assertEmpty($user->recordSubCategories);
	}

	/**
	 * @test
	 */
	public function a_user_has_record_sub_categories_will_return_filled_collection(): void
	{
		$user = $this->createUser();
		$cat1 = $this->createRecordSubCategory(['user_id' => $user->getId()]);
		$cat2 = $this->createRecordSubCategory(['user_id' => $user->getId()]);

		self::assertCount(2, $user->recordSubCategories);
		self::assertTrue($user->recordSubCategories->contains('id', $cat1->id));
		self::assertTrue($user->recordSubCategories->contains('id', $cat2->id));
	}
}