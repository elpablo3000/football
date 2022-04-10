<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Play
 *
 * @property int $id
 * @property int $fixture_id
 * @property int $team_first_id
 * @property int $team_first_result
 * @property int $team_second_id
 * @property int $team_second_result
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Play extends Model
{
	protected $table = 'plays';

	protected $casts = [
		'fixture_id' => 'int',
		'played' => 'int',
		'team_first_id' => 'int',
		'team_first_result' => 'int',
		'team_second_id' => 'int',
		'team_second_result' => 'int'
	];

	protected $fillable = [
		'fixture_id',
		'team_first_id',
		'team_first_result',
		'team_second_id',
		'team_second_result'
	];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixture() {
        return $this->hasMany('App\Models\Fixture');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teamFirst() {
        return $this->hasOne('App\Models\Team', 'id', 'team_first_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teamSecond() {
        return $this->hasOne('App\Models\Team', 'id', 'team_second_id');
    }

}
