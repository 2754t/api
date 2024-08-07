<?php

declare(strict_types=1);

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'nickname' => ['required'],
            'email' => ['required'],
            'desired_position' => ['nullable'],
            'pitcher_flag' => ['nullable'],
            'catcher_flag' => ['nullable'],
            'batting_order_bottom_flag' => ['nullable'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nickname' => 'ニックネーム',
            'email' => 'メールアドレス',
            'desired_position' => '希望ポジション',
            'pitcher_flag' => 'ピッチャーフラグ',
            'catcher_flag' => 'キャッチャーフラグ',
            'batting_order_bottom_flag' => '先発時打順下位フラグ',
        ];
    }
}
