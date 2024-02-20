<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\StartingMember
 */
class StartingMemberResource extends JsonResource
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
            'player_id' => new PlayerResource($this->whenLoaded('player')),
            'activity_id' => $this->activity_id,
            'starting_lineup' => $this->starting_lineup,
            'position' => $this->position,
            'batting_order' => $this->batting_order,
        ];
    }
}
