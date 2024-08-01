<?php

namespace App\Models;

use App\Enums\Answer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Attendance
 *
 * @property int         $id                  出欠ID
 * @property int         $team_id             チームID
 * @property int         $activity_id         活動ID
 * @property int         $player_id           選手ID
 * @property int         $answer              出欠回答
 * @property Carbon|null $answer_yes_datetime 出席回答日
 * @property Carbon|null $answer_due          指定回答日
 * @property int         $penalty             ペナルティ
 * @property bool        $dh_flag             DHフラグ
 * @property string|null $note                備考
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Attendance extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'activity_id' => 'integer',
        'player_id' => 'integer',
        'answer' => Answer::class,
        'answer_yes_datetime' => 'datetime',
        'answer_due' => 'datetime',
        'penalty' => 'integer',
        'dh_flag' => 'boolean',
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
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function starting_member(): HasOne
    {
        return $this->hasOne(StartingMember::class, 'attendance_id');
    }

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
