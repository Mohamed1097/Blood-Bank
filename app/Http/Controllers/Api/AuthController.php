<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\City;
use App\Models\Token;
use App\Models\ClientPost;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request)
    {
      if(count($request->all())!=9)
      {
          return responseJson(0,'there is something wrong try again later');
      }  
    //   $request->name=ucwords($request->name);
    //   $request->email=ucwords($request->email);  
      $validator= validator()->make($request->all(),[
            'name'=>'required|min:2',
            'email'=> 'required|email:rfc,dns|unique:clients',
            'password' => ['required', 
            'min:6', 
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/', 
            'confirmed'],
            'phone'=>'required|regex:/(01)[0-9]{9}/|digits:11|unique:clients',
            'd_o_b'=>'required|date_format:Y-m-d|before:18 years ago',
            'last_donation_date'=>'required|date_format:Y-m-d|before:tomorrow',
            'city_id'=>'required|exists:cities,id',
            'blood_type_id'=>'required|exists:blood_types,id',
        ]);
        if($validator->fails())
        {
            if($validator->errors()->first()=='The password format is invalid.')
            {
                return responseJson(0,'The Password must have at least 6 chars and contains at least 3 of a-z or A-Z and number and special chars',$validator->errors());
            }
            return responseJson(0,[$validator->errors()->first()],$validator->errors());    
        }
        $request->merge(['password'=>bcrypt($request->password),'allowed_blood_types_ids'=>$request->blood_type_id,'allowed_governorates_ids'=>City::find($request->city_id)->governorate_id]);
        $client=Client::create($request->all());
        $client->api_token=Str::random(60);
        $client->save();
        return responseJson('1','تمت الاضافه بنجاح',['api_token'=>$client->api_token,'client'=>$client]);  
    }
    public function login(Request $request)
    { 
        $validator= validator()->make($request->all(),[
            'phone'=>'required|regex:/(01)[0-9]{9}/|digits:11',
            'password' => 'required|min:6', 
        ]); 
        if($validator->fails())
        {
            return responseJson(0,[$validator->errors()->first()],$validator->errors());   
        }
        $client=Client::where('phone',$request->phone)->first();
        if($client!=null)
        {
            if(Hash::check($request->password,$client->password))
            {
                if($client->is_active)
                {
                    $client->api_token=Str::random(60);
                    $client->save();
                    return responseJson('1','تم تسجيل الدخول',['api_token'=>$client->api_token,
                    'client'=>$client]);
                }
                else
                {
                    return responseJson('0','تم حظرك من الدخول');
                }
                
            }
            else
            {
                return responseJson('0','بيناتك خاطئ'); 
            }
        }
        else
        {
            return responseJson('0','بيناتك خاطئ');
        }
        
    }
    public function logout(Request $request)
    {
        $client=$request->user();
        // $this->removeToken(client)
        $client->api_token=null;
        $client->save();
        return responseJson(1,'تم تسجيل الخروج');
    }
    public function getNotificationSettings(Request $request)
    {
        $client=$request->user();
        return responseJson('1','success',['allowed_governorates'=>explode(',',$client->allowed_governorates_ids),
        'allowed_blood_types'=>explode(',',$client->allowed_blood_types_ids)]);
    }
    public function editNotificationSettings(Request $request)
    {
        $client=$request->user();
        if($client==null)
        {
            $client=Client::where('api_token',$request->api_token)->first();
        }   
        $newGovernorates=$request->allowed_governorates_ids;
        $newBloodTypes=$request->allowed_blood_types_ids;
        if(count($newGovernorates)!=0)
        {
            if(count(array_diff($newGovernorates,explode(',',$client->allowed_governorates_ids)))!=0||
            ($request->user()!=null&&count(array_diff($newGovernorates,explode(',',$client->allowed_governorates_ids)))!=0))
            {
                $validator=""; 
                $newGovernorates=['governorate'=>$newGovernorates];
                $validator=validator()->make($newGovernorates,[
                    'governorate'=>'required|array',
                    "governorate.*"=>"exists:governorates,id|distinct|integer",
                ]);
                if($validator->fails())
                {
                    return responseJson(0,'You Must Enter Valid Governorate',$validator->errors());
                }  
                if($request->user()!=null)
                {
                    $client->allowed_governorates_ids=implode(',',$newGovernorates['governorate']);
                }
                else
                {
                    $client->allowed_governorates_ids=implode(',',array_merge(explode(',',$client->allowed_governorates_ids),
                    $newGovernorates['governorate']));
                }
            }  
        }
        else
        {
            $client->allowed_governorates_ids=null;   
        }
        if(count($newBloodTypes)!=0)
        {
            if(count(array_diff($newBloodTypes,explode(',',$client->allowed_blood_types_ids)))!=0
            ||($request->user()!=null&&count(array_diff($newBloodTypes,explode(',',$client->allowed_blood_types_ids)))!=0))
            {
                $validator=""; 
                $newBloodTypes=['blood-type'=>$newBloodTypes];
                $validator=validator()->make($newBloodTypes,[
                    'blood-type'=>'required|array',
                    "blood-type.*"=>"exists:blood_types,id|distinct|integer",
                ]);
                if($validator->fails())
                {
                    return responseJson(0,'You Must Enter Valid Blood Types',$validator->errors());
                }
                if($request->user()!=null)
                {
                    $client->allowed_blood_types_ids=implode(',',$newBloodTypes['blood-type']);
                }
                else
                $client->allowed_blood_types_ids=implode(',',array_merge(explode(',',$client->allowed_blood_types_ids),$newBloodTypes['blood-type']));
            }  
        }
        else
        {
            $client->allowed_blood_types_ids=null;
        }
        $client->save();
        return responseJson(1,'success');          
    }


    public function getProfile(Request $request)
    {
        $client=$request->user();
        return responseJson(1,'success',$client);
    }
    public function editProfile(Request $request)
    {
        $client=$request->user();
        $rules=[
            'name'=>'required|min:2',
            'email'=> 'required|email:rfc,dns|unique:clients,email,'.$request->user()->id,
            'password' => ['min:6', 
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/', 
            'confirmed'],
            'phone'=>'required|regex:/(01)[0-9]{9}/|digits:11|unique:clients,phone,'.$request->user()->id,
            'd_o_b'=>'required|date_format:Y-m-d|before:18 years ago',
            'last_donation_date'=>'required|date_format:Y-m-d|before:tomorrow',
            'city_id'=>'required|exists:cities,id',
            'blood_type_id'=>'required|exists:blood_types,id',
        ];
        $validator= validator()->make($request->all(),$rules);
        if($validator->fails())
        {
            if($validator->errors()->first()=='The password format is invalid.')
            {
                return responseJson(0,'The Password must have at least 6 chars,contains at least 3 of a-z or A-Z , number and special char',$validator->errors());
            }
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        if(isset($request->password));
        {
            $request->merge(['password'=>bcrypt($request->password)]); 
        }
        $client->update($request->all());
        $id=$request->user()->city_id;
        $r=new Request(['api_token'=>$client->api_token,
        'allowed_blood_types_ids'=>['blood_type_id'=>$client->blood_type_id],
        'allowed_governorates_ids'=>['governorate_id'=>City::where('id',$id)->first()->governorate_id]]);
        $this->editNotificationSettings($r);
        $client->save();
        return responseJson(1,'succes',$client);
    }

    public function sendPinCode(Request $request)
    {
            if(count($request->all())!=1)
            {
                return responseJson(0,'there is something wrong try again later');
            }  
            $rules=['phone'=>'required|regex:/(01)[0-9]{9}/|digits:11|exists:clients,phone'];
            $validator=validator()->make($request->all(),$rules);
            if($validator->fails())
            {
                return responseJson(0,$validator->errors()->first(),$validator->errors());
            }
            $client=Client::where('phone',$request->phone)->first();
            $client->pin_code=rand(100000, 999999);
            $client->save();
            Mail::to($client->email)
                ->bcc('mi0530838@gmail.com')
                ->send(new ResetPassword($client));
            if(count(Mail::failures())==0)
            {
                return responseJson(1,'please,Check Your Email');
            }
            else
            {
                return responseJson(0,'there ia something wrong try again later',Mail::failures());
            }    
            
    }
    public function resetPassword(Request $request)
    {
        if(count($request->all())!=3)
        {
            return responseJson(0,'there is something wrong try again later');
        }  
        $rules=[
            'pin_code'=>'required|exists:clients,pin_code',
            'password' => ['required', 
            'min:6', 
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/', 
            'confirmed'],
        ];
        $validator=validator()->make($request->all(),$rules);
        if($validator->fails())
        {
            if($validator->errors()->first()=='The password format is invalid.')
            {
                return responseJson(0,'The Password must have at least 6 chars and contains at least 3 of a-z or A-Z and number and special chars',$validator->errors());
            }
            return responseJson(0,'هذا الكود غير صحيح');
        }
        $client=Client::where('pin_code',$request->pin_code)->first();
        $client->pin_code=null;
        $client->password=bcrypt($request->password);
        $client->save();
        return responseJson(1,'تم تعديل كلمة المرور بنجاح');  
    }
    public function toggleFavourite(Request $request)
    {
        $clientId=$request->user()->id;
        $validator=validator()->make(request()->all(),[
            'post_id'=>"required|exists:posts,id"
        ]);
        if($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['client_id'=>$clientId]);
        $toggle=$request->user()->posts()->toggle($request->post_id);
        return responseJson(1,'success',$toggle);
    }
    public function getFavourites(Request $request)
    {
        $clientId=$request->user()->id;
        if(ClientPost::where('client_id',$clientId)->get()->all()==[])
        {
            return responseJson(0,'انت ليس لديك مقالات مفضله');
        }
        $posts=$request->user()->posts()->paginate();
        // $posts= ClientPost::rightJoin('posts', function($join) {
        //     $join->on('posts.id', '=', 'client_post.post_id');
        //   })
        //   ->where('client_id',$clientId)
        //   ->get();
        return responseJson(1,'success',$posts);
    }
    public function registerToken(Request $request)
    {
        $validator=validator()->make($request->all(),['token'=>'required','type'=>'required in:android,ios']);
        if($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        Token::where('token',$request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson('1','تم التسجيل بنجاح');
    }
    public function removeToken(Request $request)
    {
        $client=$request->user();
        // $validator=validator()->make($request->all(),['token'=>'required']);
        // if($validator->fails())
        // {
        //     return responseJson(0,$validator->errors()->first(),$validator->errors());
        // }
        $client->api_token=null;
        $client->save();
        if($request->has('token'))
        Token::where('token',$request->token)->delete();
        return responseJson(1,'تم تسجيل الخروج');
    }
    
   
}
