<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients=new Client();
        $message=null;
        if($request->has('blood_type_id'))
        {
            $validator=validator()->make($request->all(),['blood_type_id'=>'exists:blood_types,id','filter'=>'integer|between:1,3']);
            if($validator->fails())
            {
                return abort(404);

            }  
            $clients=$clients->where('blood_type_id',$request->blood_type_id);
        }
        if($request->has('city_id'))
        {
            $validator=validator()->make($request->all(),['city_id'=>'exists:cities,id','filter'=>'integer|between:1,3']);
            if($validator->fails())
            {
                return abort(404);

            }  
            $clients=$clients->where('city_id',$request->city_id);
        }
        if(!$clients->count())
        {
            $message='There Is No Data';
        }
        return view('clients.index',['title'=>'Clients','clients'=>$clients->paginate(1)->appends(request()->query()),'message'=>$message]);
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
    public function show(Request $request,$id)
    {
        $client=Client::findOrFail($id);
        $title=$client->name.' Details';
        return view('clients.show',['title'=>$title,'client'=>$client]);  
       
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
        $validator=validator()->make($request->all(),['is_active'=>'required|boolean']);
        if($validator->fails())
        {
            return responseJson(0,'there is something wrong try Again Later');
        }
        else
        {

            $client=Client::findOrFail($id);
            $client->is_active=$request->is_active;
            $client->save();
            return responseJson(1,'success',['is_active'=>$client->is_active]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
