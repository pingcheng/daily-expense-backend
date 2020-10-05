<?php

namespace Tests\Unit;

use App\Models\Record\Category;
use App\Models\Record\Record;
use App\Models\Record\SubCategory;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCaseBase;

class TestCase extends TestCaseBase
{

	use DatabaseMigrations;

	protected function createUser(array $data = []): User {
		return User::factory()->create($data);
	}

	protected function createRecord(array $data = []): Record {
		return Record::factory()->create($data);
	}

	protected function createRecordCategory(array $data = []): Category {
		return Category::factory()->create($data);
	}

	protected function createRecordSubCategory(array $data = []): SubCategory {
		return SubCategory::factory()->create($data);
	}
}
