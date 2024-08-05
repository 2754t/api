<?php

declare(strict_types=1);

namespace App\Http\Requests\Password;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string|PasswordRule>>
     */
    public static function rules(): array
    {
        return [
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
            'password' => '新しいパスワード',
            'password_confirmation' => '新しいパスワード(確認用)',
        ];
    }
}
