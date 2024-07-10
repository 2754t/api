<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Link
 */
class LinkResource extends JsonResource
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
            'activity' => new ActivityResource($this->whenLoaded('activity')),
            'url' => $this->url,
        ];
    }
}
