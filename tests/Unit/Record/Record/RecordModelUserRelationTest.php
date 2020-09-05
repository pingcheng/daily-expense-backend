<?php


namespace Tests\Unit\Record\Record\Record;


use Tests\Unit\TestCase;

class RecordModelUserRelationTest extends TestCase
{
	/**
	 * @test
	 */
	public function record_can_belong_to_a_user(): void
	{
		$user = $this->createUser();
		$record = $this->createRecord(['user_id' => $user->getId()]);
		self::assertNotNull($record->user);
		self::assertEquals($user->getId(), $record->user->getId());
	}

	/**
	 * @test
	 */
	public function broken_user_relation_will_return_null(): void
	{
		$record = $this->createRecord();
		self::assertNull($record->user);
	}
}