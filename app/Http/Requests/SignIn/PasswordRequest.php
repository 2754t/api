<?php

declare(strict_types=1);

namespace App\Http\Requests\SignIn;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string|PasswordRule>>
     */
    public static function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password:player'],
            'password' => ['required', 'confirmed', 'string', new PasswordRule()],
            'password_confirmation' => ['required'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'current_password' => '現在のパスワード',
            'password' => '新しいパスワード',
            'password_confirmation' => '新しいパスワード(確認用)',
        ];
    }
}
