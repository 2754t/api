<?php

declare(strict_types=1);

namespace App\Utilities;

use Exception;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * ストレージへのファイル操作を管理する
 */
class FileUtility
{
    /**
     * 一時保存ファイル用の文字列生成
     */
    public static function createTemporaryFilename(): string
    {
        return uniqid(Auth::id() . bin2hex(random_bytes(8)));
    }

    /**
     * パス文字列の前後の不要な区切り文字を取り除く
     */
    public static function trimDot(string $path): string
    {
        return trim($path, '.');
    }

    /**
     * パス文字列の前後の不要な区切り文字を取り除く
     */
    public static function trimSeparator(string $path): string
    {
        return trim($path, '\\/');
    }

    /**
     * documents diskを取得
     */
    public static function documentsAdapter(): FilesystemAdapter
    {
        return Storage::disk('documents');
    }

    /**
     * temporary diskを取得
     */
    public static function temporaryAdapter(): FilesystemAdapter
    {
        return Storage::disk('temporary');
    }

    /**
     * documents on GCS diskを取得
     */
    public static function documentsOnGcsAdapter(): FilesystemAdapter
    {
        return Storage::disk('documents_on_gcs');
    }

    /**
     * uploads on GCS diskを取得
     */
    public static function uploadsOnGcsAdapter(): FilesystemAdapter
    {
        return Storage::disk('uploads_on_gcs');
    }

    /**
     * ディレクトリ存在チェック
     */
    public static function checkAndCreateDirectory(FilesystemAdapter $adapter, string $target_file_path): bool
    {
        $target_directory = pathinfo($target_file_path, PATHINFO_DIRNAME);
        if (!$adapter->exists($target_directory)) {
            // 保存先ディレクトリが存在しない場合、ディレクトリを作成する
            Log::info('create new directory. ', [
                'target_file_path' => $target_file_path,
                'target_directory' => $target_directory,
                'full_path' => $adapter->path($target_directory),
            ]);
            if (!$adapter->makeDirectory($target_directory)) {
                // ディレクトリ作成に失敗した場合
                Log::error('create new directory failed.', ['target_directory' => $target_directory]);

                throw new Exception('ディレクトリ作成に失敗しました。');
            }
        }

        return true;
    }

    /**
     * ディレクトリ存在チェック
     */
    public static function checkAndCreateDirectoryDocument(string $target_file_path): bool
    {
        return static::checkAndCreateDirectory(static::documentsAdapter(), $target_file_path);
    }

    /**
     * ディレクトリ存在チェック
     */
    public static function checkAndCreateDirectoryTemporary(string $target_file_path): bool
    {
        return static::checkAndCreateDirectory(static::temporaryAdapter(), $target_file_path);
    }
}
