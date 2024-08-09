<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\PitchingResult
 */
class PitchingResultResource extends JsonResource
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
            'activity' => new ActivityResource($this->whenLoaded('activity')),
            'player' => new PlayerResource($this->whenLoaded('player')),
            'outs' => $this->outs,
            'hits' => $this->hits,
            'walks' => $this->walks,
            'strikeouts' => $this->strikeouts,
            'runs' => $this->runs,
            'earned_run' => $this->earned_run,
            'pitching_evaluation' => $this->pitching_evaluation,
        ];
    }
}
