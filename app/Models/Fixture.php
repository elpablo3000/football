<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fixture
 *
 * @property int $id
 * @property int $week_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Fixture extends Model
{
	protected $table = 'fixtures';

	protected $casts = [
		'week_number' => 'int'
	];

	protected $fillable = [
		'week_number'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plays() {
        return $this->hasMany('App\Models\Play');
    }
}
