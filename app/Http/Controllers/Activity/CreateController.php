<?php

declare(strict_types=1);

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CreateRequest;
use App\Http\Resources\ActivityResource;
use App\UseCase\Actions\Activity\CreateAction;

class CreateController extends Controller
{
    public function __invoke(CreateAction $action, CreateRequest $request): ActivityResource
    {
        $activity = $action($request);

        return new ActivityResource($activity);
    }
}
