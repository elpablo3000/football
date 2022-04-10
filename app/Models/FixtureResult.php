<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FixtureResult
 *
 * @property int $id
 * @property int $team_id
 * @property int $week_number
 * @property int $played
 * @property int $won
 * @property int $drawn
 * @property int $loosed
 * @property int $goal_difference
 * @property int $predictions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FixtureResult extends Model
{
	protected $table = 'fixture_results';

	protected $casts = [
		'team_id' => 'int',
		'week_number' => 'int',
		'played' => 'int',
		'won' => 'int',
		'drawn' => 'int',
		'loosed' => 'int',
		'goal_difference' => 'int',
		'predictions' => 'int'
	];

	protected $fillable = [
		'team_id',
		'week_number',
		'played',
		'won',
		'drawn',
		'loosed',
		'goal_difference',
		'predictions'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function team() {
        return $this->hasOne('App\Models\Team', 'id', 'team_id');
    }
}
