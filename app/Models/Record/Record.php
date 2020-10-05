<?php


namespace App\Models\Record;


use App\Models\Model;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Record
 * @package App\Models\Record
 *
 * @property integer $id
 * @property integer $sub_category_id
 * @property string $description
 * @property integer $amount
 * @property integer $user_id
 * @property User|null user
 * @property SubCategory|null subCategory
 * @property Carbon datetime
 */
class Record extends Model
{
	protected $table = 'records';

	protected $casts = [
		'id' => 'int',
		'sub_category_id' => 'int',
		'description' => 'string',
		'amount' => 'int',
		'datetime' => 'datetime',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function subCategory(): BelongsTo
	{
		return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
	}

	public function outputModel(): array
	{
		return [
			'id' => $this->id,
			'description' => $this->description,
			'amount' => $this->amount,
			'datetime' => $this->datetime,
			'subCategory' => [
				'id' => $this->subCategory->id ?? null,
				'name' => $this->subCategory->name ?? null,
			],
			'category' => [
				'id' => $this->subCategory->category->id ?? null,
				'name' => $this->subCategory->category->name ?? null,
				'type' => $this->subCategory->category->type ?? null,
			]
		];
	}
}