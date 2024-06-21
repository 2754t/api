<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Stadium
 *
 * @property int         $id                スタメンID
 * @property int         $team_id           チームID
 * @property string      $stadium_name      球場名
 * @property string      $address           住所
 * @property int|null    $weekday_cost      平日使用料金/h
 * @property int|null    $saturday_cost     土曜日使用料金/h
 * @property int|null    $sunday_cost       日曜日使用料金/h
 * @property bool|null   $free_parking_flag 無料駐車場フラグ
 * @property int|null    $parking_cost      近隣有料駐車場参考料金
 * @property string|null $nearest_station   最寄駅
 * @property int|null    $from_station      最寄駅からの徒歩時間(m)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Stadium extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'weekday_cost' => 'integer',
        'saturday_cost' => 'integer',
        'sunday_cost' => 'integer',
        'free_parking_flag' => 'boolean',
        'parking_cost' => 'integer',
        'from_station' => 'integer',
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

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
