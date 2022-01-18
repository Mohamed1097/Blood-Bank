<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('front.login',['title'=>'تسجيل الدخول']);
    }
    public function check(Request $request)
    {
        $messages=[
            'phone.required'=>__('message.phone'),
            'password.required'=>__('message.password')
        ];
        $validator=validator()->make($request->all(),['phone'=>'required','password'=>'required'],$messages);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($messages);
        }
        
        $creds = $request->only('phone','password');
        if( Auth::guard('web-client')->attempt($creds) ){
            if(Auth::guard('web-client')->user()->is_active==1)
            {
                return redirect(route('client.home'));
            }
            return $this->logout();
        }
        else
        {
            return redirect()->back()->withErrors(['failed'=>__('message.failed')]);
        }
    }
    public function logout()
    {
        Auth::guard('web-client')->logout();
        return redirect(route('client.home'));
    }
}
