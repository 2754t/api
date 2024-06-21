<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Team
 *
 * @property int         $id        チームID
 * @property string      $team_name チーム名
 * @property string      $team_kana チーム名かな
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Team extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
