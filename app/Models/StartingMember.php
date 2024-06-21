<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\Position;
use Illuminate\Support\Carbon;

/**
 * App\Models\StartingMember
 *
 * @property int           $id              スタメンID
 * @property int           $team_id         チームID
 * @property int           $attendance_id   出欠ID
 * @property bool          $starting_flag   スタメンフラグ
 * @property int|null      $batting_order   打順
 * @property Position|null $position        スタートポジション
 * @property Position|null $second_position 第二ポジション
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 */
class StartingMember extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'attendance_id' => 'integer',
        'starting_flag' => 'boolean',
        'batting_order' => 'integer',
        'position' => Position::class,
        'second_position' => Position::class,
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
