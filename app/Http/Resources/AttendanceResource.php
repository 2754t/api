<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Attendance
 */
class AttendanceResource extends JsonResource
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
            'answer' => $this->answer,
            'answer_yes_datetime' => $this->answer_yes_datetime,
            'answer_due' => $this->answer_due,
            'penalty' => $this->penalty,
            'dh_flag' => $this->dh_flag,
            'note' => $this->note,
        ];
    }
}
