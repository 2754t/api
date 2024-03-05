<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Activity
 */
class ActivityResource extends JsonResource
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
            'stadium_id' => $this->stadium_id,
            'activity_date' => $this->activity_date,
            'play_time' => $this->play_time,
            'activity_type' => $this->activity_type,
            'confirmed_flag' => $this->confirmed_flag,
            'dh_type' => $this->dh_type,
            'entry_cost' => $this->entry_cost,
        ];
    }
}
