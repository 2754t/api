<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Player
 */
class PlayerResource extends JsonResource
{
    /**
     * @param  Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'team_id' => $this->team_id,
            'role' => $this->role,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'player_number' => $this->player_number,
            'desired_position' => $this->desired_position,
            'position_joined' => $this->position_joined,
            'pitcher_flag' => $this->pitcher_flag,
            'catcher_flag' => $this->catcher_flag,
        ];
    }
}
