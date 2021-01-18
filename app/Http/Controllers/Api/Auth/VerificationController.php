<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // request()->validate([
        //     'otp'  =>  ['required'],
        // ]);

        $otp = OtpCode::where('otp', $request->otp)->first();
        if (!$otp) {
            return response()->json([
                'response_code' =>  '01',
                'response_message'  =>  'Kode OTP tidak invalid.'
            ], 200);
        }

        $currentDateTime = Carbon::now();

        if ($currentDateTime > $otp->valid_until) {
            return response()->json([
                'response_code' =>  '01',
                'response_message'  =>  'Kode OTP sudah kadaluarsa. Silahkan regenerate kode OTP!'
            ], 200);
        }

        $user = User::find($otp->user_id);
        $user->email_verified_at = $currentDateTime;
        $user->save();

        $otp->delete();

        return json_encode([
            'responce_code'=>'00',
            'responce_message'=>'Berhasil verifikasi.',
            'data'=> $user
        ], 200);
    }
}
