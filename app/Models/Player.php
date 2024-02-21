<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * App\Models\Player
 *
 * @property int $id 選手ID
 * @property int $team_id チームID
 * @property string $email メールアドレス
 * @property string $password パスワード
 * @property string|null $access_token アクセストークン
 * @property \Illuminate\Support\Carbon|null $access_token_expired アクセストークン有効期限
 * @property string|null $remember_token リメンバートークン
 * @property int $role 権限
 * @property string $last_name 姓
 * @property string $first_name 名
 * @property int|null $player_number 背番号
 * @property int|null $desired_position 希望ポジション
 * @property string|null $positions カンマ区切りの守備位置
 * @property bool $pitcher_flag 投手フラグ
 * @property bool $catcher_flag 捕手フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereAccessTokenExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereCatcherFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereDesiredPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player wherePitcherFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player wherePlayerNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player wherePositions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Player extends Model implements Authenticatable
{
    use AuthAuthenticatable;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'pitcher_flag' => 'boolean',
        'catcher_flag' => 'boolean',
        'role' => 'integer',
        'access_token_expired' => 'datetime',
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
        'remember_token',
    ];

    
}
