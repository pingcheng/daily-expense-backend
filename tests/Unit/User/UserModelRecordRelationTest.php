<?php


namespace Tests\Unit\User;

use Carbon\Carbon;
use Tests\Unit\TestCase;

class UserModelRecordRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function user_with_no_records_will_return_empty_collection(): void
	{
		$user = $this->createUser();
		self::assertEmpty($user->records);
	}

	/**
	 * @test
	 */
	public function user_with_records_will_return_filled_collection(): void
	{
		$user = $this->createUser();
		$record1 = $this->createRecord(['user_id' => $user->getId()]);
		$record2 = $this->createRecord(['user_id' => $user->getId()]);

		self::assertCount(2, $user->records);
		self::assertTrue($user->records->contains('id', $record1->id));
		self::assertTrue($user->records->contains('id', $record2->id));
	}

	/**
	 * @test
	 */
	public function records_collection_will_sorted_from_new_to_old(): void
	{
		$user = $this->createUser();

		$this->createRecord([
			'user_id' => $user->getId(),
			'datetime' => Carbon::now()
		]);

		$recordLatest = $this->createRecord([
			'user_id' => $user->getId(),
			'datetime' => Carbon::now()->addHour()
		]);

		$recordEarliest = $this->createRecord([
			'user_id' => $user->getId(),
			'datetime' => Carbon::now()->subHour()
		]);


		self::assertCount(3, $user->records);
		self::assertEquals($recordLatest->id, $user->records->first()->id);
		self::assertEquals($recordEarliest->id, $user->records->last()->id);
	}

	/**
	 * @test
	 */
	public function records_can_be_paginated(): void
	{
		$user = $this->createUser();
		for ($i=0; $i<25; $i++) {
			$this->createRecord(['user_id' => $user]);
		}

		self::assertEquals(2, $user->records()->paginate()->lastPage());
		self::assertCount(15, $user->records()->paginate()->items());
		self::assertCount(10, $user->records()->paginate(null, ['*'], 'page', 2)->items());
	}
}