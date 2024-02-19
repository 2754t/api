<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class StartingMember extends Model implements Authenticatable
{
    use AuthAuthenticatable;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'player_id' => 'integer',
        'activity_id' => 'integer',
        'starting_lineup' => 'integer',
        'position' => 'integer',
        'batting_order' => 'integer',
    ];
}
