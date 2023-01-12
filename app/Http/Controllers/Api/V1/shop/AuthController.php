<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Customer;
use App\Shop;
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

class AuthController extends Controller
{
    private $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
        // dd($user->findOrfail(1));
    }


    public function login(Request $request)
    {


        $shop = Shop::where('email',$request->email)->first();

        $input = $request->only('email', 'password');
// dd($input);
        $jwt_token = null;
        $token = JWTAuth::attempt($input);
     // dd($token);
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
}