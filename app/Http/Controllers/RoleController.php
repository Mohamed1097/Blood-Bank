<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $roles=Role::paginate();
     return view('roles.index',['title'=>'Roles','roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create',['title'=>'Add New Role']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $valdiator= validator()->make($request->all(),[
            'name'=>'required|string|min:2|unique:roles,name',
            'display_name'=>'required|string|min:2',
            'permission_list'=>'required|array',
            'permission_list.*'=>"exists:permissions,id|distinct|integer"
        ]);
        if($valdiator->fails())
        {
            return redirect(route('admin.roles.create'))->withErrors($valdiator->errors());
        }
        $role=Role::create($request->all());
        $role->permissions()->attach($request->permission_list);
        return redirect(route('admin.roles.index'))->withErrors(['message'=>'تم اضافة الرتبه بنجاح']);
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
        $valdiator=validator()->make(['id'=>$id],['id'=>'exists:roles,id']);
        if($valdiator->fails())
        {
            return abort(404);
        }
        return view('roles.edit',['title'=>'Edit Role','role'=>Role::findOrFail($id)]);
        
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
        $request->merge(['id'=>$id]);
        $valdiator= validator()->make($request->all(),[
            'id'=>'exists:roles,id',
            'name'=>'required|string|min:2|unique:roles,name,'.$id,
            'display_name'=>'required|string|min:2',
            'permission_list'=>'required|array',
            'permission_list.*'=>"exists:permissions,id|distinct|integer"
        ]);
        if($valdiator->fails())
        {
            return redirect(route('roles.edit'))->withErrors($valdiator->errors());
        }
        $role=Role::findOrFail($id);
        $role->update($request->all());
        $role->permissions()->sync($request->permission_list);
        return redirect(route('admin.roles.index'))->withErrors(['message'=>'تم تعديل الرتبه بنحاح']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::findOrFail($id);
        if(!Auth::user()->hasRole($role->name))
        {
            if(!$role)
            {
                return false;
            }
            $role->delete();
            return responseJson('1','تم مسح الرتبه بنجاح');
        }
        return responseJson(0,'لا تستطيع مسح هذه الرتبه');
    }
}
