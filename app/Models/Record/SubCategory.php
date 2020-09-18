<?php


namespace App\Models\Record;


use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SubCategory
 * @package App\Models\Record
 *
 * @property int $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $name
 * @property Collection|Record[] records
 * @property Category|null category
 */
class SubCategory extends Model
{
	protected $table = 'sub_categories';

	protected $fillable = [
		'user_id',
		'category_id',
		'name'
	];

	protected $casts = [
		'id' => 'integer',
		'user_id' => 'integer',
		'category_id' => 'integer',
		'name' => 'string',
	];

	public function records(): HasMany
	{
		return $this->hasMany(Record::class, 'sub_category_id', 'id');
	}

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}
}