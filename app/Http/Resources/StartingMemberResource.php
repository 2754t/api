<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Attendance;
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
            'team_id' => new TeamResource($this->whenLoaded('team')),
            'attendance_id' => new AttendanceResource($this->whenLoaded('attendance')),
            'starting_flag' => $this->starting_flag,
            'batting_order' => $this->batting_order,
            'position' => $this->position,
            'second_position' => $this->second_position,
        ];
    }
}
