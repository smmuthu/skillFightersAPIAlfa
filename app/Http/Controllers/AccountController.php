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

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use Session;

class AccountController extends Controller
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
        $data = $request->all();
        //echo "<pre>";print_r($request->file('image'));exit;
        //echo "<pre>";print_r($data);exit;
        $rules = [
            'firstname' => 'required|regex:/^[A-Za-z. -]+$/',
            'lastname' => 'required|regex:/^[A-Za-z. -]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone_no' => 'required|min:10|numeric',
            'department' => 'required|regex:/^[A-Za-z. -]+$/',
            'occupation' => 'required|regex:/^[A-Za-z. -]+$/',
        ];

        $validator = Validator::make($data,$rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();            
            return response()->json(['status_code'=>404,'message'=>'Invalid.','error'=>true,'validation'=>$messages],404);
        }
        else{
            $data['password'] = Hash::make($request->input('password'));
            $user = User::create($data);
            if($request->file('image')) {
                $image_name = $request->file('image')->getClientOriginalName();
                $image_extension = $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(base_path(). '/public/images/user/'.$user->id, strtolower($image_name));
                $user->image = $image_name;    
            }
            $user->save();
            $name = array('name'=>$request->input('firstname'));
            $email = $request->input('email');
            Mail::send('user.mail.welcome', $name, function($message) use ($user) {
                $message->to($user->email, 'Skill Fighters')
                        ->subject('Confirmation Mail');
            });
            return response()->json(['status_code'=>200,'message'=>'User has been created.','error'=>false,'user'=>$user],200);   
        }
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
        //
    }
    public function resetpassword(Request $request)
    {        
        try {
            $users = User::where('email', '=' ,$request->input('email'));
            $user = $users->first();           
        } catch (ModelNotFoundException $e) {
            return response()->json(['status_code'=>404,'error'=>true,'message'=>'User not found.'],404);
        }
        if($user->email){
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $password = implode($pass);
            $user_details = array('name'=>$user->firstname,'password'=>$password);
            Mail::send('user.mail.resetpassword',  $user_details, function($message) use ($user){
                $message->to($user->email, 'Skill Fighters')
                        ->subject('Reset Password');
            }); 
            return response()->json(['status_code'=>200,'error'=>false,'message'=>'User found.','password'=>implode($pass)],200);
        }
    }
}
