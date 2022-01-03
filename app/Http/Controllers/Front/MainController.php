<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\DonationRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $title='Blood Bank';
        $postMessage=null;
        $donationRequestMessage=null;
        $posts=Post::take(5)->get();
        if(!$posts->count())
        {
         $postMessage='لا يوجد منشورات';   
        }
        $donationRequests=new DonationRequest();
        $validator=validator()->make($request->all(),[
            'city_id'=>'exists:cities,id',
            'blood_type_id'=>'exists:blood_types,id'
        ]);
        if($validator->fails())
        {
            
            $donationRequests=$donationRequests->take(4);
            if(!$donationRequests->count())
            {
                $donationRequests=$donationRequests->get();
                $donationRequestMessage='لا توجد طلبات تبرع بالدم';
                return view('front.home',compact('title','donationRequests','posts','postMessage','donationRequestMessage'));
            }
            else
            {
                $donationRequests=$donationRequests->get(); 
                return view('front.home',compact('title','donationRequests','posts','postMessage','donationRequestMessage'));
            }
        }
        if($request->has('city_id'))
        {
            $donationRequests=$donationRequests->where('city_id',$request->city_id);
        }
        if($request->has('blood_type_id'))
        {
            $donationRequests=$donationRequests->where('blood_type_id',$request->blood_type_id);
        }
        if(!$donationRequests->count())
        {
            $donationRequestMessage='لا توجد طلبات تبرع بالدم';
        }
        $donationRequests=$donationRequests->take(4)->get();
        return view('front.home',compact('title','donationRequests','posts','postMessage','donationRequestMessage'));
    }
    public function toggleFavourite(Request $request)
    {
        $toggle = $request->user()->posts()->toggle($request->post_id);
        return responseJson(1,'success',$toggle);
    }
}
