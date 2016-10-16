<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Hash;

use App\User;

use Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Input;

use Mail;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //echo "test";exit;
        // $data = $request->all();
        // echo "<pre>";print_r($data);exit;
        // $rules = [
        //     'firstname' => 'required|regex:/^[A-Za-z. -]+$/',
        //     'lastname' => 'required|regex:/^[A-Za-z. -]+$/',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        //     'phone_no' => 'required|min:10|numeric',
        //     'department' => 'required|regex:/^[A-Za-z. -]+$/',
        //     'occupation' => 'required|regex:/^[A-Za-z. -]+$/',
        // ];

        // $validator = Validator::make($data,$rules);
        // if ($validator->fails()) {
        //     $messages = $validator->errors()->all();            
        //     return response()->json(['status_code'=>404,'message'=>'Invalid.','error'=>true,'validation'=>$messages],404);
        // }
        // else{
        //     $data['password'] = Hash::make($request->input('password'));                        
        //     $user = User::create($data);
        //     $name = array('name'=>$request->input('firstname'));
        //     $email = $request->input('email');
        //     Mail::send('user.mail.welcome', $name, function($message) use ($user) {
        //         $message->to($user->email, 'Skill Fighters')
        //                 ->subject('Confirmation Mail');
        //     });
        //     return response()->json(['status_code'=>200,'message'=>'User has been created.','error'=>false,'user'=>$user],200);   
        // }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        try {
            $user = User::findOrFail($id);    
            return response()->json(['status_code'=>200,'error'=>false,'user'=>$user],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status_code'=>404,'error'=>true,'message'=>'User not found.'],404);
        }                    
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
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status_code'=>404,'error'=>true,'message'=>'User not found.'],404);
        } 
        $user->update($request->all());
        if ($request->input('name'))
        {
            $name = $request->input('name');
            $user->update(array('name'=>$name));
        }     
        if ($request->input('email'))
        {
            $email = $request->input('email');
            $user->update(array('email'=>$email));
        }
        if ($request->input('password'))
        {
            $password = Hash::make($request->input('password'));
            $user->update(array('password'=>$password));
        }
     
        return response()->json(['status_code'=>200,'error'=>false, 'message'=>'User data has been updated successfully.', 'user'=>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);            
        } catch (ModelNotFoundException $e) {
            return response()->json(['status_code'=>404,'error'=>true,'message'=>'User not found.'],404);
        }
        if($user->id){
            $user->delete();
            return response()->json(['status_code'=>200,'error'=>false,'message'=>'User has been deleted.'],200);
        }
    }
}
