<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Uniform
 */
class UniformResource extends JsonResource
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
            'player' => new PlayerResource($this->whenLoaded('player')),
            'cap_flag' => $this->cap_flag,
            'cap_size' => $this->cap_size,
            'cap_adjuster_flag' => $this->cap_adjuster_flag,
            'shirt_flag' => $this->shirt_flag,
            'back_name' => $this->back_name,
            'player_number' => $this->player_number,
            'shirt_size' => $this->shirt_size,
            'shirt_sleeve' => $this->shirt_sleeve,
            'pants_flag' => $this->pants_flag,
            'pants_type' => $this->pants_type,
            'pants_hem' => $this->pants_hem,
            'pants_inseam' => $this->pants_inseam,
            'total_fee' => $this->total_fee,
            'note' => $this->note,
            'confirm_flag' => $this->confirm_flag,
        ];
    }
}
