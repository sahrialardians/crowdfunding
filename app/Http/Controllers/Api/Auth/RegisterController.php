<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        request()->validate([
            'name'  =>  ['required'],
            'email'  =>  ['required', 'email', 'unique:users,email'],
        ]);

        $now = Carbon::now();

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make('default')
        ]);

        OtpCode::create([
            'otp' => rand(100000,999999),
            'user_id' => $user->id,
            'valid_until' => $now->addMinute(10)
        ]);

        return json_encode([
            'responce_code'=>'00',
            'responce_message'=>'Berhasil register, silahkan cek email anda!',
            'data'=> $user
        ], 200);
    }
}
