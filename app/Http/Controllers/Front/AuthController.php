<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function check(Request $request)
    {
        $validator=validator()->make($request->all(),['phone'=>'required','password'=>'required']);
        if($validator->fails())
        {
            return redirect()->back()->withErrors(['fail'=>'email Or Password Is Invalid']);
        }
        
        $creds = $request->only('phone','password');
        if( Auth::guard('web-client')->attempt($creds) ){
         
            return redirect(route('client.home'));
        }
        else
        {
            return redirect()->back()->withErrors(['fail'=>'email Or Password Is Invalid']);
        }
    }
    public function logout()
    {
        Auth::guard('web-client')->logout();
        return redirect(route('client.home'));
    }
}
