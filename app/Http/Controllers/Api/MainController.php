<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\Governorate;
use App\Models\City;
use App\Models\DonationRequest;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Token;
use App\Models\Setting;

class MainController extends Controller
{
    public function getGovernorates()
    {
      return responseJson(1,'success',Governorate::all());
    }
    public function getPosts()
    {
        if(isset(request()->post_category_id))
        {
            $validator=validator()->make(request()->except('api_token'),['post_category_id'=>'exists:post_categories,id']);
            if($validator->fails())
            return responseJson(0,$validator->errors());
            return responseJson(1,'success',Post::where('post_category_id',request()->post_category_id)->with('PostCategory')->paginate(10));
        }
        return responseJson(1,'success',Post::with('PostCategory')->paginate(10));  
    }
    public function getPost(Request $request)
    {
        if(count($request->all())!=2)
        {
            return responseJson(0,'there is something wrong try again later');
        }
        $validator=validator()->make($request->except('api_token'),['id'=>'required|exists:posts,id']);
        if($validator->fails())
        return responseJson(0,$validator->errors()->first(),$validator->errors());
        $post=Post::where('id',$request->id)->with('PostCategory')->first(); //find
        if($post->count()==0)
        {
            return responseJson(0,'failed'); 
        }
        return responseJson(1,'success',$post);
    }
    public function getCities(Request $request)
    {
        if(isset($request->governorate_id))
        {
            $validator=validator()->make($request->all(),['governorate_id'=>'exists:governorates,id']);
            if($validator->fails())
            {
                return responseJson(0,'failed');
            }
            $cities=City::where('governorate_id',$request->governorate_id);
            if($cities->count()==0)
            {
                return responseJson(0,'failed'); 
            }
            return responseJson(1,'success',$cities->pluck('name','id'));
        }
        else
        {
            return responseJson(1,'success',city::with('Governorate')->paginate(10));
        }
    }
    Public function getBloodTypes()
    {
        return responseJson(1,'success',BloodType::all());
    }
    public function getSettings()
    {
        $settings=Setting::all();
        if($settings->count()==0)
        {
            return responseJson(0,'failed');
        }
        return responseJson(1,'success',$settings);
    }
    // public function addSetting(Request $request)
    // {
    //     if(Setting::count()==1)
    //     {
    //         return responseJson(0,'غير مسموح اضافة اعدادات اخرى');
    //     }
    //     $validator= validator()->make($request->all(),[
    //         'about'=>'required',
    //         'email'=> 'required|email:rfc,dns',
    //         'phone'=>'required|regex:/(01)[0-9]{9}/|digits:11',
    //         'notification_settings_text'=>'required',
    //         'fb_link'=>'required|url',
    //         'insta_link'=>'required|url',
    //         'tw_link'=>'required|url',
    //         'youtube_link'=>'required|url',
    //     ]);
    //     if($validator->fails())
    //     {
    //         return responseJson(0,$validator->errors()->first(),$validator->errors());
    //     }
    //     $setting=Setting::create($request->all());
    //     return responseJson(1,'تمت اضافة الاعدادات ',$setting);
    // }
    public function addMessage(Request $request)
    {
        $validator=validator()->make($request->except('api_token'),[
            'message_title'=>"required",
            "message"=>"required"
        ]);
        if($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['client_id'=>$request->user()->id]);
        $request->user()->contacts()->create($request->except('api_token'));
        return responseJson(1,'تم ارسال الرساله بنجاح');
    }
    // public function getMessages()
    // {
    //     return responseJson(1,'success',Contact::with('client')->paginate(10));
    // }
    public function addDonationRequest(Request $request)
    {
        $validator=validator()->make($request->all(),[
            'patient_name'=>'required',
            'patient_phone'=>'required|regex:/(01)[0-9]{9}/|digits:11',
            'city_id'=>'required|exists:cities,id',
            'age'=>'required:digits',
            'blood_type_id'=>'required|exists:blood_types,id',
            'hospital_address'=>'required',
            'bags_num'=>'required|integer',
            'latitude'=>'required',
            'longitude'=>'required',
        ]);
        if($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['client_id'=>$request->user()->id]);
        $donationRequest=DonationRequest::create($request->all());

        $tokens = Token::whereHas('client',
        function ($client) use ($donationRequest,$request) {
           $client->
           whereRaw('FIND_IN_SET(?,allowed_governorates_ids)',
        [$donationRequest->city->governorate_id])->whereRaw('FIND_IN_SET(?,allowed_blood_types_ids)',
        [$donationRequest->blood_type_id])->has('tokens')->where('id','!=',$request->user()->id);
        })->pluck('token')->toArray();

        $clientIds=Token::whereIn('token',$tokens)->distinct()->pluck('client_id')->toArray();
        
        if(count($clientIds))
        {
            $notification=$donationRequest->notification()->create(
                ['title'=>'هناك حاله تبرع قريبه منك',
                'content'=>$donationRequest->BloodType->name.'محتاج متبرع لفصيلة']
            );
            $notification->clients()->attach($clientIds);
            //     $title = $notification->title;
            //     $body = $notification->content;
            //     $data = [
            //         'donation_request_id' => $donationRequest->id
            //     ];
            //     $send = notifyByFirebase($title, $body, $tokens, $data);
            //     info("firebase result: " . $send); 
        }
        return responseJson(1, 'تم الاضافة بنجاح', $donationRequest->load('client')); 
           
    }
    public function getDonationRequests(Request $request)
    {
        $donationRequests=new DonationRequest();
        if($request->has('blood_type_id'))
        {
            $validator=validator()->make($request->all(),['blood_type_id'=>'exists:blood_types,id']);
            if($validator->fails())
            {
                return responseJson(0,$validator->errors()->first(),$validator->errors());
            }  
            $donationRequests=$donationRequests->where('blood_type_id',$request->blood_type_id);
        }
        if($request->has('governorate_id'))
        {
            $validator=validator()->make($request->all(),['governorate_id'=>'exists:governorates,id']);
            if($validator->fails())
            {
                return responseJson(0,$validator->errors()->first(),$validator->errors());
            }  
            $donationRequests=$donationRequests->whereIn('city_id',City::where('governorate_id',$request->governorate_id)
            ->pluck('id')->toArray());
        }
        $donationRequests=$donationRequests->with('city','bloodtype')->paginate();
        if($donationRequests->count()==0)
        {
            return responseJson(0,'لا يوجد طلبات تبرع');
        }
        return responseJson(1,'success',$donationRequests);
    }
    public function getDonationRequest(Request $request)
    {
        $validator=validator()->
        make($request->all(),['required|donation_request_id'=>'exists: donation_requests,id']);
        if($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        return responseJson(1,'success',DonationRequest::with(['City','Client'])->find($request->donation_request_id));     
    }
    public function getNotifications(Request $request)
    {
        // dd($request->user()->notifications()->toSql());
        $notifications=Notification::leftJoin('client_notification', function($join) {
            $join->on('notifications.id', '=', 'client_notification.notification_id');
          })
          ->where('client_id',$request->user()->id)
          ->get(['notifications.title','notifications.content','notifications.donation_request_id'])->toArray();
          if($notifications==[])
          {
              return responseJson(1,"لا يوجد لديك اشعارات");
          }
          else
          {
              return responseJson(1,'success',$notifications);
          }
    }

}
