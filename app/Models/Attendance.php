<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Attendance
 *
 * @property int $id 出欠ID
 * @property int $team_id チームID
 * @property int $player_id 選手ID
 * @property int $activity_id 活動ID
 * @property int $answer 出欠回答
 * @property int $dh_flag DHフラグ
 * @property int|null $second_position 第二ポジション
 * @property string|null $note 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDhFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereSecondPosition($value)
 * @property-read \App\Models\Player|null $player
 * @mixin \Eloquent
 */
class Attendance extends Model implements Authenticatable
{
    use AuthAuthenticatable;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'player_id' => 'integer',
        'activity_id' => 'integer',
        'answer' => 'integer',
    ];

    /*
    |-------------------
    | スコープ
    |-------------------
    |
    */

    /*
    |-------------------
    | リレーション
    |-------------------
    |
    */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
