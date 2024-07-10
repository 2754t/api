<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Link
 *
 * @property int    $id          リンクID  
 * @property int    $team_id     チームID
 * @property int    $player_id   選手ID
 * @property int    $activity_id 活動ID
 * @property string $url         URL
 */
class Link extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'player_id' => 'integer',
        'activity_id' => 'integer',
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

    public function activity(): BelongsTo
    {
        return $this->BelongsTo(Activity::class);
    }

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
