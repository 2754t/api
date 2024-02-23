<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\Position;

/**
 * App\Models\StartingMember
 *
 * @property int $id オーダーID
 * @property int $team_id チームID
 * @property int $player_id 選手ID
 * @property int $activity_id 活動ID
 * @property int $attendance_id 出欠ID
 * @property boolean $starting_lineup スタメン
 * @property Position|null $position 守備位置
 * @property int|null $batting_order 打順
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Player|null $player
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereBattingOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereStartingLineup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StartingMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StartingMember extends Model implements Authenticatable
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
        'starting_lineup' => 'boolean',
        'position' => Position::class,
        'batting_order' => 'integer',
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
        return $this->BelongsTo(Player::class);
    }

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
