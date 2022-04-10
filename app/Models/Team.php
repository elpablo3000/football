<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Team extends Model
{
	protected $table = 'teams';

	protected $fillable = [
		'name'
	];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function firstPlays() {
        return $this->hasMany('App\Models\Play', 'team_first_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secondPlays() {
        return $this->hasMany('App\Models\Play', 'team_second_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixtureResults() {
        return $this->hasMany('App\Models\FixtureResult');
    }
}
