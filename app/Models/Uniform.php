<?php

namespace App\Models;

use App\Enums\CapSize;
use App\Enums\HemType;
use App\Enums\PantsType;
use App\Enums\ShirtSize;
use App\Enums\SleeveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Uniform
 *
 * @property int             $id                ユニフォーム注文ID
 * @property int             $team_id           チームID
 * @property int             $player_id         選手ID
 * @property bool            $cap_flag          帽子フラグ
 * @property CapSize|null    $cap_size          帽子サイズ[54:S 56:M 58:L 60:O 62:XO 64:XXO]
 * @property bool            $cap_adjuster_flag アジャスター(レール式)フラグ
 * @property bool            $shirt_flag        シャツフラグ
 * @property string|null     $back_name         背ネーム
 * @property int|null        $player_number     背番号
 * @property ShirtSize|null  $shirt_size        シャツサイズ[88:S 92:M 96:L 100:O 104:XO 108:XA 112:XXA 116:XXB 122:B122 128:B128 134:B134 140:B140]
 * @property SleeveType|null $shirt_sleeve      袖丈[1:短め 2:ノーマル 3:やや長め 4:長め]
 * @property bool            $pants_flag        パンツフラグ
 * @property PantsType|null  $pants_type        パンツサイズ[1:ショート 2:レギュラー 3:ロング 4:ボンズ 5:スリムロング]
 * @property HemType|null    $pants_hem         すそ[1:ゴム入り 2:ゴムなし 3:ひっかけ]
 * @property int|null        $pants_inseam      股下
 * @property int|null        $total_fee         合計金額
 * @property string|null     $note              備考
 * @property bool            $confirm_flag      確定フラグ
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 */
class Uniform extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'player_id' => 'integer',
        'cap_flag' => 'boolean',
        'cap_size' => CapSize::class,
        'cap_adjuster_flag' => 'boolean',
        'shirt_flag' => 'boolean',
        'player_number' => 'integer',
        'shirt_size' => ShirtSize::class,
        'shirt_sleeve' => SleeveType::class,
        'pants_flag' => 'boolean',
        'pants_type' => PantsType::class,
        'pants_hem' => HemType::class,
        'pants_inseam' => 'integer',
        'total_fee' => 'integer',
        'confirm_flag' => 'boolean',
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

    /*
    |-------------------
    | アクセサ
    |-------------------
    |
    */
}
