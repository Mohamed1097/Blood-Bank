<?php

namespace App\Http\Controllers;

use App\Models\DonationRequest;
use App\Models\ClientNotification;
use Illuminate\Http\Request;

class DonationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $message=null;
        $validator=validator()->make($request->all(),['city_id'=>'exists:cities,id','blood_type_id'=>'exists:blood_types,id','filter'=>'integer|between:1,3']);
        if($validator->fails())
        {
            return abort(404);
        }  
        $donationRequests=new DonationRequest();
        if($request->has('blood_type_id'))
        {
           
            $donationRequests=$donationRequests->where('blood_type_id',$request->blood_type_id);
        }
        if($request->has('city_id'))
        {
            $donationRequests=$donationRequests->where('city_id',$request->city_id);
        }
        if(!$donationRequests->count())
        {
            $message='There Is No Data';
        }
        return view('donation-requests.index',['title'=>'Donation Requests','donationRequests'=>$donationRequests->paginate(2)->appends(request()->query()),'message'=>$message]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $donationRequest=DonationRequest::findOrFail($id);
        $title=$donationRequest->patient_name.' Request';
        return view('donation-requests.show',['title'=>$title,'donationRequest'=>$donationRequest]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $donationRequest=DonationRequest::findOrFail($id);
        $notification=$donationRequest->notification;
        if(isset($notification))
        {

            $client_notification=ClientNotification::where('notification_id',$notification->id);
            if($client_notification->count())
            {
                $client_notification->delete();
                $notification->delete();  
            }
        }
        $donationRequest->delete();
        return responseJson(1,'تم مسح طلب التبرع بنجاح');
    }
}
