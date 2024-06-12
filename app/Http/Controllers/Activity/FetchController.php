<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\UseCase\Actions\Activity\FetchAction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchController extends Controller
{
    public function __invoke(FetchAction $action, Request $request): AnonymousResourceCollection
    {
        $year = (int)$request->input('year');
        $month = (int)$request->input('month');

        $activities = $action($year, $month);

        return ActivityResource::collection($activities);
    }
}
