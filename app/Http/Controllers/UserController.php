<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $validator=validator()->make($request->all(),['email'=>'required|email|exists:users,email','password'=>'required']);
        if($validator->fails())
        {
            return redirect()->back()->with('fail','Email Or Password Is Invalid');
        }
        $creds = $request->only('email','password');
        if( Auth::guard('web')->attempt($creds) ){
            return redirect()->route('admin.home');
        }
        else
        {
            return redirect()->back()->with('fail','Email Or Password Is Invalid');
        }
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('admin.login');
    }
    public function changePassword()
    {
        return view('user.set-new-password',['title'=>'Set New Password']);
    }
    public function updatePassword(Request $request)
    {
        $user=Auth::user();
        $validator=validator()->make($request->all(),[
            'current-password'=>'required',
            'password'=>'required|string|min:8|confirmed'
        ]);
        if($validator->fails())
        {
            return redirect(route('admin.change-password'))->withErrors($validator->errors());
        }
        if(!Hash::check($request->input('current-password'), $user->password))
        {
            return redirect(route('admin.change-password'))->withErrors(['current-password'=>'The Current Password Is Invalid']);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect(route('admin.change-password'))->withErrors(['message'=>'تم تعديل كلمة المرور بنجاح']);
    }
    public function index()
    {
        return view('user.index',['title'=>'users','users'=>User::paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create',['title'=>'Add New User']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=validator()->make($request->all(), [
            'name' => 'required|string|min:2',
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|email|unique:users,email',
            'roles_list'  => 'required|array',
            'roles_list.*'=>'exists:roles,id'
        ]);
        if($validator->fails())
        {
            dd($validator->errors());
            return redirect(route('admin.users.create'))->withErrors($validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->except('roles_list'));
        $user->roles()->attach($request->roles_list);
        return redirect(route('admin.users.index'))->withErrors(['message'=>'تم اضافة المستخدم بنجاح']);
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
        $valdiator=validator()->make(['id'=>$id],['id'=>'exists:users,id']);
        if($valdiator->fails())
        {
            return abort(404);
        }
        return view('user.edit',['title'=>'Edit User','user'=>User::findOrFail($id)]);
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
            'id'=>'exists:users,id',
            'roles_list'=>'required|array',
            'roles_list.*'=>"exists:roles,id|distinct|integer"
        ]);
        if($valdiator->fails())
        {
            return redirect(route('admin.users.edit',['user'=>$id]))->withErrors($valdiator->errors());
        }
        $user=User::findOrFail($id);
        $user->roles()->sync($request->roles_list);
        return redirect(route('admin.users.index'))->withErrors(['message'=>'تم تعديل المستخدم بنجاح']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        if($user->id==auth()->user()->id)
        {
            return responseJson(0,'لا تستطيع مسح هذا المستخدم');
        }
        $user->delete();
        return responseJson(1,'تم مسح المستخدم بنجاح');
    }
}
