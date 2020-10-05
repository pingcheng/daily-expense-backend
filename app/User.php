<?php

namespace App;

use App\Models\Model;
use App\Models\Record\Category;
use App\Models\Record\Record;
use App\Models\Record\SubCategory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 *
 * @property integer|null $id
 * @property Collection|Record[] $records
 * @property Collection|Record[] $recordSubCategories
 */
class User extends Model implements AuthenticatableContract,
	AuthorizableContract,
	CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'id' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    public function setPassword(string $password): self {
    	$this->setAttribute('password', Hash::make($password));
    	return $this;
	}

    public function getPassword(): string {
    	return $this->getAttributeFromArray('password');
	}

	public function getId(): ?int {
    	$id = $this->getAttributeFromArray('id');
    	return $id === null ? null : (int) $id;
	}

	public function setName(string $name): self {
    	$this->setAttribute('name', $name);
    	return $this;
	}

	public function getName(): string {
    	return $this->getAttributeFromArray('name') ?? '';
	}

	public function getEmail(): string {
    	return $this->getAttributeFromArray('email') ?? '';
	}

	public function getAvatar(): string {
    	$name = str_replace(' ', '+', $this->getName());
    	return "https://ui-avatars.com/api/?name={$name}";
	}

	public function records(): HasMany {
    	return $this->hasMany(Record::class, 'user_id', 'id')
			->orderByDesc('datetime');
	}

	public function recordSubCategories(): HasMany
	{
    	return $this->hasMany(SubCategory::class, 'user_id', 'id');
	}

	public function recordCategories(): HasMany {
    	return $this->hasMany(Category::class, 'user_id', 'id');
	}
}
