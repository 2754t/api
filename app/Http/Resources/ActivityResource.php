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
            'team' => new TeamResource($this->whenLoaded('team')),
            'stadium' => new StadiumResource($this->whenLoaded('stadium')),
            'activity_datetime' => $this->activity_datetime,
            'play_time' => $this->play_time,
            'meeting_time' => $this->meeting_time,
            'meeting_place' => $this->meeting_place,
            'activity_type' => $this->activity_type,
            'confirmed_flag' => $this->confirmed_flag,
            'opposing_team' => $this->opposing_team,
            'referee_type' => $this->referee_type,
            'dh_type' => $this->dh_type,
            'recruitment' => $this->recruitment,
            'entry_cost' => $this->entry_cost,
            'belongings' => $this->belongings,
            'decide_order_flag' => $this->decide_order_flag,
            'next_send_datetime' => $this->next_send_datetime,
        ];
    }
}
