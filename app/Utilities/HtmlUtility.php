<?php

declare(strict_types=1);

namespace App\Utilities;

class HtmlUtility
{
    /**
     * &nbsp; を削除する
     */
    public static function removeNbsp(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        // <p>&nbsp;</p> の &nbsp; を削除する
        $text = preg_replace('/<p>\&nbsp;<\/p>/', '<p></p>', $text);

        if ($text === null) {
            return null;
        }

        // <p>&nbsp;</p> 以外に &nbsp; がある場合は半角スペースに変換する
        return preg_replace('/\&nbsp;/', ' ', $text);
    }
}
