<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

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
        'access_token_expired' => 'datetime:Y-m-d',
    ];
    
}
