<?php


namespace App\Models\Record;


use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 * @package App\Models\Record
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $type
 * @property Collection|SubCategory[] subCategories
 */
class Category extends Model
{
	public const TYPE_EXPENSE = 0;
	public const TYPE_INCOME = 1;

	protected $table = 'categories';

	protected $fillable = [
		'user_id',
		'name',
		'type'
	];

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int',
		'name' => 'string',
		'type' => 'int',
	];

	public function subCategories(): HasMany
	{
		return $this->hasMany(SubCategory::class, 'category_id', 'id')
			->where('user_id', $this->user_id);
	}
}