<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
	{
		Schema::create('categories', static function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('user_id');
			$table->string('name');
			$table->smallInteger('type')->comment('expense - 0, income - 1');
			$table->timestamps();

			$table->index(['user_id', 'name']);
		});

		Schema::create('sub_categories', static function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('category_id');
			$table->string('name');
			$table->timestamps();

			$table->index(['user_id', 'category_id', 'name']);
		});

        Schema::create('records', static function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sub_category_id');
            $table->string('description')->default('');
            $table->integer('amount');
            $table->integer('user_id');
            $table->dateTime('datetime');
            $table->timestamps();

            $table->index(['user_id', 'sub_category_id', 'datetime']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
	{
        Schema::dropIfExists('records');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
    }
}
