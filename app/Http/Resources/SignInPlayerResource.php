<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Player
 */
class SignInPlayerResource extends JsonResource
{
    /**
     * @param  Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'team' => new TeamResource($this->whenLoaded('team')),
            'email' => $this->email,
            'password_token' => $this->password_token,
            'password_token_expired' => $this->password_token_expired,
            'access_token' => $this->access_token,
            'access_token_expired' => $this->access_token_expired,
            'role' => $this->role,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'nickname' => $this->nickname,
            'player_number' => $this->player_number,
            'desired_position' => $this->desired_position,
            'position_joined' => $this->position_joined,
            'pitcher_flag' => $this->pitcher_flag,
            'catcher_flag' => $this->catcher_flag,
            'batting_order_bottom_flag' => $this->batting_order_bottom_flag,
        ];
    }
}
