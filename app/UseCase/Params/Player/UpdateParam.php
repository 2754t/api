<?php

declare(strict_types=1);

namespace App\UseCase\Params\Player;

use App\Shared\Param;

/**
 * @property string   $nickname
 * @property string   $email
 * @property int|null $desired_position
 * @property bool     $pitcher_flag
 * @property bool     $catcher_flag
 * @property bool     $batting_order_bottom_flag
 */
class UpdateParam extends Param
{
    protected $fillable = [
        'nickname',
        'email',
        'desired_position',
        'pitcher_flag',
        'catcher_flag',
        'batting_order_bottom_flag',
    ];

    protected $casts = [
        'nickname' => 'string',
        'email' => 'string',
        'desired_position' => 'integer',
        'pitcher_flag' => 'boolean',
        'catcher_flag' => 'boolean',
        'batting_order_bottom_flag' => 'boolean',
    ];
}
