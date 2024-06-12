<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public static function rules(): array
    {
        return [
            'stadium_id' => ['required'],
            'activity_datetime' => ['required'],
            'play_time' => ['required'],
            'activity_type' => ['required'],
            'confirmed_flag' => ['required'],
            'dh_type' => ['nullable'],
            'entry_cost' => ['nullable'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'stadium_id' => '球場ID',
            'activity_datetime' => '	活動日時',
            'play_time' => '活動の予定時間/h',
            'activity_type' => '活動内容',
            'confirmed_flag' => '活動確定フラグ',
            'dh_type' => 'DHタイプ',
            'entry_cost' => '参加費',
        ];
    }
}
