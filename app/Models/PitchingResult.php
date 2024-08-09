<?php

namespace App\Models;

use App\Enums\PitchingEvaluation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\PitchingResult
 *
 * @property int                     $id                   出欠ID
 * @property int                     $team_id              チームID
 * @property int                     $activity_id          活動ID
 * @property int                     $player_id            選手ID
 * @property int                     $outs                 奪アウト数(投球イニング×3)
 * @property int                     $hits                 被安打
 * @property int                     $walks                与四死球
 * @property int                     $strikeouts           奪三振
 * @property int                     $runs                 失点
 * @property int                     $earned_run           自責点
 * @property PitchingEvaluation|null $pitching_evaluation  登板評価[1:勝 2:負 3:ホールド 4:セーブ]
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 */
class PitchingResult extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'activity_id' => 'integer',
        'player_id' => 'integer',
        'outs' => 'integer',
        'hits' => 'integer',
        'walks' => 'integer',
        'strikeouts' => 'integer',
        'runs' => 'integer',
        'earned_run' => 'integer',
        'pitching_evaluation' => PitchingEvaluation::class,
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

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
