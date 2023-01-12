<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Admin;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use DB;
use JWTAuthException;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
	private $user;


    public function __construct(Admin $admin)
    {
        $this->user = $admin;
        \Config::set('jwt.user', "App\Admin");
        \Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => \App\Admin::class,
        ]]);


        // dd($user->findOrfail(1));
    }


    public function alogin(Request $request){

        $check = Admin::where('number',$request->get('username'))->first();
        // dd($check);
        if(!(isset($check)))
        {
            $user = new Admin();
            $user->number = $request->username;

            $user->otp = rand(100000,999999);
            $user->otp_varify = 0;
            $user->spassword = 'Applified@2021';
            $user->password = bcrypt('Applified@2021');
            $user->save();
            return response()->json(['success' => 1, 'id' => $user->id, 'otp' => $user->otp,'user'=>$user,'username'=>$request->username ]);
            
        }

        if (is_numeric($request->username)) {
            $user=Admin::where('number',$request->username)->first();
            $user->otp = rand(100000,999999);
            $user->otp_varify = 0;
            $user->save();
            return response()->json(['success' => 1, 'id' => $user->id, 'otp' => $user->otp,'admin_user'=>$user,'username'=>$request->username ]);


        }else{

         $user=Admin::where('email',$request->username)->value('spassword');

         $user->otp = rand(100000,999999);
         $user->otp_varify = 0;
         $user->save();
         return response()->json(['success' => 1, 'id' => $user->id, 'otp' => $user->otp,'admin_user'=>$user,'username'=>$request->username ]);

     }

 }

 public function adminotpVerify(Request $request, Admin $admin){

    \Config::set('jwt.user', "App\Admin");
    \Config::set('auth.providers', ['users' => [
        'driver' => 'eloquent',
        'model' => \App\Admin::class,
    ]]);

    if (is_numeric($request->username)) {
        $admin=Admin::where('number',$request->username)->first();
        if($admin->otp == $request->otp){
            $credentials = [
                'number' => $request->username,
                'password'=>$admin->spassword
            ]; 
            // dd($credentials);   
        }else{
            return response()->json(['success' => 0, 'message' => 'otp is wrong! please try again!']);
        }   
    }else{
        $admin=Admin::where('number',$request->username)->first();
        
        if($admin->otp == $request->otp){
            $credentials = [
                'email' => $request->username,
                'password'=>$admin->spassword
            ];    
        }else{
            return response()->json(['success' => 0, 'message' => 'otp is wrong! please try again!']);
        }  
    }

    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['success' => 0, 'message' => 'These credentials do not match our records.'], 200);
        } 


    } catch (JWTAuthException $e) {
        return response()->json(['success' => 0, 'message' => 'failed_to_create_token'], 200);
    }

    $nuser = JWTAuth::user();

    $nuser->otp = '';
    $nuser->otp_varify = 1;
    $nuser->save();

    return response()->json(['success' => 1,  'id' => $nuser->id,'admin_user'=>$nuser ,'token' => $token, ]);

}

}