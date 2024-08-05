<?php

declare(strict_types=1);

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\SendMailRequest;
use App\Services\Exceptions\PlayerNotFoundException;
use App\Services\Exceptions\TeamNotFoundException;
use App\UseCase\Actions\Password\SendMailAction;
use App\UseCase\Exceptions\UseCaseException;
use Throwable;

/**
 * パスワードリマインダー : メール認証
 */
class SendMailController extends Controller
{
    public function __invoke(SendMailRequest $request, SendMailAction $action): void
    {
        $subdomain = $request->input('subdomain');
        $email = $request->input('email');

        // if ($subdomain === null) {
        //     // 成功時と同じレスポンスを返す
        //     return;
        // }

        try {
            $action($email);

            return;
        } catch (PlayerNotFoundException | TeamNotFoundException $e) {
            // 成功時と同じレスポンスを返す
            return;
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage());
        } catch (Throwable $e) {
            report('[送信失敗メールアドレス:' . $request->email . ']');
            report($e);
            abort(400, 'メール送信に失敗しました。メールアドレスに全角文字やスペース等が入っていないかをご確認ください。メールアドレスが正しい場合は、時間をおいて再度お試しください。');
        }
    }
}
