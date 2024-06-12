<?php

namespace App\Models;

use App\Enums\ActivityType;
use App\Enums\DHType;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * App\Models\Activity
 *
 * @property int $id 活動ID
 * @property int $team_id チームID
 * @property \Illuminate\Support\Carbon $activity_datetime 活動日時
 * @property ActivityType $activity_type 活動内容
 * @property int $stadium_id 球場ID
 * @property int $play_time 活動の予定時間/h
 * @property \Illuminate\Support\Carbon|null $next_send_datetime 次回送信日時
 * @property int $confirmed_flag 活動確定フラグ
 * @property DHType|null $dh_type DHタイプ
 * @property int|null $entry_cost 参加費
 * @property int|null $recruitment 募集人数
 * @property int $is_order オーダー決定フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereActivityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereActivityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereConfirmedFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDhType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEntryCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity wherePlayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereStadiumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereRecruitment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereIsOrder($value)
 * @mixin \Eloquent
 */
class Activity extends Model implements Authenticatable
{
    use AuthAuthenticatable;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'activity_datetime' => 'datetime',
        'activity_type' => ActivityType::class,
        'stadium_id' => 'integer',
        'play_time' => 'integer',
        'next_send_datetime' => 'datetime',
        'confirmed_flag' => 'boolean',
        'dh_type' => DHType::class,
        'entry_cost' => 'integer',
        'recruitment' => 'integer',
    ];
}
