<?php

namespace App\Models;

use App\Enums\Position;
use App\Enums\Role;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Player
 *
 * @property int           $id                        選手ID
 * @property int           $team_id                   チームID
 * @property string        $email                     メールアドレス
 * @property string        $password                  パスワード
 * @property string|null   $access_token              アクセストークン
 * @property Carbon|null   $access_token_expired      アクセストークン有効期限
 * @property Role          $role                      権限 [0:体験者 1:助っ人 2:メンバー 3:管理者]
 * @property string        $last_name                 姓
 * @property string        $first_name                名
 * @property string        $nickname                  ニックネーム
 * @property int|null      $player_number             背番号
 * @property Position|null $desired_position          希望ポジション
 * @property string|null   $position_joined           習得ポジション
 * @property bool          $pitcher_flag              投手フラグ
 * @property bool          $catcher_flag              捕手フラグ
 * @property bool          $bottom_batting_order_flag 投手時打順下位フラグ
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 */
class Player extends Model implements Authenticatable
{
    use AuthAuthenticatable;
    use Notifiable;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'access_token_expired' => 'datetime',
        'role' => Role::class,
        'player_number' => 'integer',
        'desired_position' => Position::class,
        'pitcher_flag' => 'boolean',
        'catcher_flag' => 'boolean',
        'bottom_batting_order_flag' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'access_token',
        'access_token_expired',
        'password',
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
