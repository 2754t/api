<?php

declare(strict_types=1);

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public static function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'メールアドレス',
        ];
    }
}
