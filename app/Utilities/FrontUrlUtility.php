<?php

declare(strict_types=1);

namespace App\Utilities;

use App\Models\Team;

/**
 * フロントURL
 */
class FrontUrlUtility
{
    public static function baseUrl(int $team_id): string
    {
        $team = Team::find($team_id);

        assert($team instanceof Team);

        $base_url = config('app.front_url');
        // $base_url = str_replace('http://', 'http://' . $team->subdomain . '.', $base_url);
        // $base_url = str_replace('https://', 'https://' . $team->subdomain . '.', $base_url);
        $base_url = str_replace('http://', 'http://', $base_url);
        $base_url = str_replace('https://', 'https://', $base_url);
        assert(is_string($base_url));

        return $base_url;
    }

    public static function adminBaseUrl(): string
    {
        return config('app.front_url');
    }
}
