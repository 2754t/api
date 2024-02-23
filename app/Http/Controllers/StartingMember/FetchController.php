<?php

namespace App\Http\Controllers\StartingMember;

use App\Http\Controllers\Controller;
use App\Http\Resources\StartingMemberResource;
use App\Models\StartingMember;

class FetchController extends Controller
{
    public function __invoke()
    {
        $starting_members = StartingMember::get();

        if ($starting_members->isEmpty()) {
            abort('400', "選手がいません");
        }

        dd($starting_members);

        return StartingMemberResource::collection($starting_members);
    }
}
