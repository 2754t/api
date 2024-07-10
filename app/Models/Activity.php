<?php

namespace App\Models;

use App\Enums\ActivityType;
use App\Enums\DHType;
use App\Enums\RefereeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Activity
 *
 * @property int              $id                 活動ID
 * @property int              $team_id            チームID
 * @property int              $stadium_id         球場ID
 * @property Carbon           $activity_datetime  活動日時
 * @property int              $play_time          活動の予定時間(h)
 * @property string           $meeting_time       集合時間
 * @property string           $meeting_place      集合場所
 * @property ActivityType     $activity_type      活動内容
 * @property bool             $confirmed_flag     活動確定フラグ
 * @property string|null      $opposing_team      相手チーム
 * @property RefereeType|null $referee_type       審判の種類
 * @property DHType|null      $dh_type            DHタイプ
 * @property int|null         $recruitment        募集人数
 * @property int|null         $entry_cost         参加費
 * @property string|null      $belongings         持ち物
 * @property bool             $decide_order_flag  オーダー決定フラグ
 * @property Carbon|null      $next_send_datetime 次回送信日時
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 */
class Activity extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'stadium_id' => 'integer',
        'activity_datetime' => 'datetime',
        'play_time' => 'integer',
        'activity_type' => ActivityType::class,
        'confirmed_flag' => 'boolean',
        'referee_type' => RefereeType::class,
        'dh_type' => DHType::class,
        'recruitment' => 'integer',
        'entry_cost' => 'integer',
        'decide_order_flag' => 'boolean',
        'next_send_datetime' => 'datetime',
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
    public function stadium(): HasOne
    {
        return $this->hasOne(Stadium::class, 'id', 'stadium_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class, 'activity_id', 'id');
    }
    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
