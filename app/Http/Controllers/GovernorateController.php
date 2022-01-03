<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('governorates.index',['title'=>'Governorates','governorates'=>Governorate::paginate(1)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('governorates.create',['title'=>'Add New Governorate']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=validator()->make($request->all(),['name'=>'required|unique:Governorates,name']);
        if($validator->fails())
        {
            // dd(['title'=>'Add New Governorate','errors'=>$validator->errors()->toArray()]);
            return redirect(route('governorate.create'))->withErrors($validator->errors());
        }
        Governorate::create($request->all());
        return redirect(route('governorate.index'));
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
        return view('governorates.edit',['title'=>'Edit Governorate','governorate'=>Governorate::findOrFail($id)]);
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
        $validator=validator()->make($request->all(),['name'=>'required|unique:Governorates,name']);
        if($validator->fails())
        {
            if($validator->errors()->first()=='The name has already been taken.')
            {
                return redirect(route('governorate.index'));
            }
            return redirect(route('governorate.edit',['governorate'=>$id]))->withErrors($validator->errors());
        }
        Governorate::findOrFail($id)->update($request->all());
        return redirect(route('governorate.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $governorate=Governorate::findOrFail($id);
        if(!$governorate->cities()->count()&&!Client::whereRaw('FIND_IN_SET(?,allowed_governorates_ids)', [$id])->count())
        {
            $governorate->delete();
            return responseJson(1,'تم مسح المحافظه بنجاح');
        }
        else
        {
            return responseJson(0,'لا تستطيع مسح هذه المحافظه ');
        }
    }
}
