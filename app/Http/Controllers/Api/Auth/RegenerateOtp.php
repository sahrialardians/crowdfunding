<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegenerateOtp extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $otp = OtpCode::where('otp', $request->otp)->first();

        $currentDateTime = Carbon::now();

        $user = User::find($otp->user_id);
        $user->email_verified_at = $currentDateTime;
        $user->save();

        $otp->delete();
    }
}
