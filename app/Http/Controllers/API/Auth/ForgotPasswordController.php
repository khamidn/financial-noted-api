<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{ ForgotPasswordRequest, ResetPasswordRequest};
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{ DB, Mail, Hash };
use Illuminate\Mail\Message;

class ForgotPasswordController extends Controller
{
    public function forgot(ForgotPasswordRequest $request)
    {
        User::where('email', $request->email)->firstOrFailToJson('User not found');

        $token = Str::random(20);

        try {
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);

            Mail::send('Mails.forgot', array('token' => $token), function (Message $message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset your password');
            });

            return $this->sendResponse('','Check your email.');

        } catch(\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

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
