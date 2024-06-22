<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Activity;
use App\Models\StartingMember;
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
            'team_id' => new TeamResource($this->whenLoaded('team')),
            'player' => new PlayerResource($this->whenLoaded('player')),
            'starting_member' => new StartingMemberResource($this->whenLoaded('starting_member')),
            'activity_id' => new ActivityResource($this->whenLoaded('activity')),
            'answer' => $this->answer,
            'dh_flag' => $this->dh_flag,
            'note' => $this->note,
        ];
    }
}
