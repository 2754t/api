<?php

declare(strict_types=1);

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return ActivityResource::collection(Activity::get());
    }
}
