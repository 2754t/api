<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 新規パスワードの入力内容チェック
 * 入力値が「アルファベットと数字の両方を含む半角英数字記号(半角スペースも含む)8文字以上」でなければエラーを返す
 */
class PasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(?=.*?[0-9])(?=.*?[A-Za-z])[ -~]{8,}$/', $value)) {
            $fail('validation.password_rule')->translate();
        }
    }
}
