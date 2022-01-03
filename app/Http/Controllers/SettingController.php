<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting=new Setting();
        if($setting->count())
        {
            return view('settings.index',['title'=>"Settings",'setting'=>$setting->first()]);
        }
        else
        {
            return view('settings.index',['title'=>"Settings",'message'=>'You Must Add New Settings']);  
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create',['title'=>'Add New Settings']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Setting::count())
        {
            return redirect(route('admin.settings.index'));
        }
        $validator= validator()->make($request->all(),[
            'about'=>'required',
            'email'=> 'required|email:rfc,dns',
            'phone'=>'required|regex:/(01)[0-9]{9}/|digits:11',
            'notification_settings_text'=>'required',
            'fb_link'=>'required|url',
            'insta_link'=>'required|url',
            'tw_link'=>'required|url',
            'youtube_link'=>'required|url',
        ]);
        if($validator->fails())
        {
            return redirect(route('admin.settings.create'))->withErrors($validator->errors())->withInput($request->except('_token'));
        }
        Setting::create($request->all());
        return redirect(route('admin.settings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('settings.edit',['title'=>'Edit Setting','setting'=>Setting::findOrFail($id)]);
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
        $validator= validator()->make($request->all(),[
            'about'=>'required|min:50',
            'email'=> 'required|email:rfc,dns',
            'phone'=>'required|regex:/(01)[0-9]{9}/|digits:11',
            'notification_settings_text'=>'required|min:50',
            'fb_link'=>'required|url',
            'insta_link'=>'required|url',
            'tw_link'=>'required|url',
            'youtube_link'=>'required|url',
        ]);
        if($validator->fails())
        {
            return redirect(route('admin.settings.edit',['setting'=>$id]))->withErrors($validator->errors())->withInput($request->except('_token'));
        }
        Setting::findOrFail($id)->update($request->all());
        return redirect(route('admin.settings.index'));
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
