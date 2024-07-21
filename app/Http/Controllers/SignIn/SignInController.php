<?php

namespace App\Http\Controllers\SignIn;

use App\Http\Controllers\Controller;
use App\Http\Resources\SignInPlayerResource;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SignInController extends Controller
{
    public function __invoke(Request $request): SignInPlayerResource
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $player = Player::where('email', $email)->first();

        if (!$player) {
            abort(401, 'メールアドレスまたはパスワードが間違っています。');
        }

        if (!Hash::check($password, $player->password)) {
            abort(401, 'メールアドレスまたはパスワードが間違っています。');
        }

        $player->access_token = 'access_token_' . Str::random(87);
        $player->access_token_expired = Carbon::now()->addHour();
        $player->save();

        return new SignInPlayerResource($player);
    }
}
