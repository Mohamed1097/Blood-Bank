<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cities.index',['title'=>'Cities','cities'=>City::with('governorate')->paginate(1)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create',['title'=>'Add New City','governorates'=>Governorate::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator=validator()->make($request->all(),['name'=>'required|unique:cities,name',
        'governorate_id'=>'required|exists:governorates,id']);
        if($validator->fails())
        {
          return redirect(route('cities.create'))->withErrors($validator->errors());
        }
        City::create($request->all());
        return redirect(route('cities.index'));
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
        return view('cities.edit',['title'=>'Edit City','city'=>City::findOrFail($id),'governorates'=>Governorate::all()]);
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
        $city=City::findOrFail($id);
        if($city->governorate->id==$request->governorate_id)
        {
            $validator=validator()->make($request->all(),['name'=>'required|unique:cities,name']);
            if($validator->fails())
            {
                if($validator->errors()->first()=='The name has already been taken.')
                {
                    return redirect(route('cities.index'));
                } 
                return redirect(route('cities.edit',['city'=>$id]))->withErrors($validator->errors());
            }
            $city->update($request->all());
            return redirect(route('cities.index'));
        }
        else
        {
            $validator=validator()->make($request->all(),['name'=>'required',
            'governorate_id'=>'required|exists:governorates,id']);
            if($validator->fails())
            {
                return redirect(route('cities.edit',['city'=>$id]))->withErrors($validator->errors());  
            }
            $city->update($request->all());
            return redirect(route('cities.index'));
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
        $city=City::findOrFail($id);
        if(!$city->clients()->count()&&!$city->donationRequests()->count())
        {
            $city->delete();
            return responseJson(1,'تم مسح المدينه بنجاح');
        }
        else
        {
            return responseJson(0,'لا تستطيع مسح هذه المدينه ');
        }
    }
}
