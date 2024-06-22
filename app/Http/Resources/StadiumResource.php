<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Stadium
 */
class StadiumResource extends JsonResource
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
            'stadium_name' => $this->stadium_name,
            'address' => $this->address,
            'weekday_cost' => $this->weekday_cost,
            'saturday_cost' => $this->saturday_cost,
            'sunday_cost' => $this->sunday_cost,
            'free_parking_flag' => $this->free_parking_flag,
            'parking_cost' => $this->parking_cost,
            'nearest_station' => $this->nearest_station,
            'from_station' => $this->from_station,

        ];
    }
}
