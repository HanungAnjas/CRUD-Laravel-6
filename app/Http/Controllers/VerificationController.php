<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function notice(Request $request){
        return view('notice');
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect('/pegawai');
    }

    public function send(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return redirect('/email/verify');
    }
}
