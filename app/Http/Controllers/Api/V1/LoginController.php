<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Customer;
use App\Admin;
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

class LoginController extends Controller
{
    private $admin;
  
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        // dd($user->findOrfail(1));
    }


    public function adminlogin(Request $request)
    {

        \Config::set('jwt.user', "App\Admin");
            \Config::set('auth.providers', ['admins' => [
                'driver' => 'eloquent',
                'model' => \App\Admin::class,
            ]]);
        // dd('hfvhfvvf');
        $admin = Admin::where('email',$request->email)->first();
        // dd($admin);
        $input = $request->only('email', 'password');
// dd($input);
        $jwt_token = null;
        $token = JWTAuth::attempt($input);
     dd($token);
        if (!$jwt_token = JWTAuth::attempt($input)) {

            return response()->json([

                'success' => 0,

                'message' => 'Invalid Email or Password',

            ], 200);
        }
        else
        {
        // dd(JWTAuth::attempt($input));
            return response()->json([

                'success' => 1,

                'token' => $token,

                'message'=>"Login successfully"

            ], 200);
        }
    }

    public function otpVerify(Request $request){
        \Config::set('jwt.user', "App\User");
        \Config::set('auth.providers.users.model', \App\User::class);

        if (is_numeric($request->username)) {
            $user=User::where('number',$request->username)->first();
            if($user->otp == $request->otp){
                $credentials = [
                    'number' => $request->username,
                    'password'=>$user->spassword
                ];    
            }else{
                return response()->json(['success' => 0, 'message' => 'otp is wrong! please try again!']);
            }   
        }else{
            $user=User::where('number',$request->username)->first();

            if($user->otp == $request->otp){
                $credentials = [
                    'email' => $request->username,
                    'password'=>$user->spassword
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

        $cuser=JWTAuth::user();

        $cuser->otp = '';
        $cuser->otp_verify = 1;
        $cuser->save();

        return response()->json(['success' => 1,  'id' => $cuser->id, 'user'=>$cuser ,'token' => $token, ]);

    }
    public function changepassword(Request $request){

        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

        $user = JWTAuth::user();

        if (Hash::check($request->oldpassword, $user->password)) { 
            $user->password = Hash::make($request->password);
            $user->spassword = $request->password;
            $user->save();
            return response()->json(['success' => 1,'message'=>'password changed successfully']);
        }else{
            return response()->json(['success' => 0,'message'=>'old password not match']);
        }
    }

    public function update_user(Request $request)
    {
        $param = $request->all();

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required|numeric',
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return response()->json(['status' => false, 'message' => $errors], 200);
        }

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, 'users', storage_path("app/public/uploads/users/"));
            $param['image']= $name;
        }

        $update= User::findOrfail(JWTAuth::user()->id);
        $update->fname = $param['name'];
        $update->number = $param['number'];
        $update->image = !empty($param['image']) ? $param['image'] : $update->image;
        $update->save();
        $update->image = !empty($update->image) ? url('/storage/uploads/users/Medium').'/'.$update->image : '';

        return response()->json(['status' => true, 'message' => 'User was successfully updated.', 'data' => $update ], 200);
    }

    public function getUser(Request $request){

        $user = User::findOrfail(JWTAuth::user()->id);
        $user->image = !empty($user->image) ? url('/storage/uploads/users/Medium').'/'.$user->image : '';

        if ($user) {
         return response()->json(['status' => 1, 'message' => 'User details fetched successfully updated.', 'data' => $user ], 200); 
     }else{
      return response()->json(['status' => 0, 'message' => 'No data found!', 'data' => '' ], 200);  
  }  
}

public function updateProfileDetail(Request $request){
    $param = $request->all();
    $user = User::where('id',JWTAuth::user()->id)->update($param);

    if ($user) {
     return response()->json(['status' => 1, 'message' => 'User details Updated successfully updated.', 'data' =>  User::findOrfail(JWTAuth::user()->id) ], 200); 
 }else{
  return response()->json(['status' => 0, 'message' => 'No data found!', 'data' => '' ], 200);  
}
}

}
