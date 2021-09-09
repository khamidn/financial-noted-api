<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\{ DB, Hash };
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request)
    {
        $token = $request->token;

        if (!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {
            return $this->sendError('Invalid token.');
        }

        if (!$user = User::where('email', $passwordResets->email)->first()) {
            return $this->sendError('User doesn\'t exists.');
            
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $passwordResets->email)->delete();

        return $this->sendResponse('', 'Reset password successfully.');

    }
}
