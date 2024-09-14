<?php

namespace App\Http\Controllers;

use App\Http\Controllers\site\CommonFunction;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

    }

    public function sendotp(Request $request){
        $mobileno = $request->get('mobileno');
        $user =User::where('phone',$mobileno)->first();
        if ($user){
            $user->otp = $this->generateOtp();
            $user->save();
             CommonFunction::send_sms($mobileno,"Systemeye Exchange OTP: ".$user->otp);
            $message = "otp sent";
            $responseCode = 1;
            $status = 200;
        }else {
            $status = 200;
            $responseCode = -1;
            $message = "user not registered";
        }

        return response()->json(['message'=>$message,'responseCode'=>$responseCode]);
    }

    public function veirfyOtp(Request $request){
        $user =User::where('phone',$request->get('mobileno'))->where('otp',$request->get('otp'))->first();
        if ($user){
            Auth::login($user);
            $user->otp = null;
            $user->last_login = Carbon::now();
            $user->save();
            /* @var User $user*/
            $user = Auth::user();
            $userdata = $this->userAuthData();
            $token = $user->createToken('app')->accessToken;

            return response()->json(['status'=>1,'token'=>$token,'user'=>$userdata],200);
        }else{
            return response()->json(['status'=>-1,'message'=>'Invalid OTP']);
        }
    }

    private function userAuthData (){
        return [
          'name'=>Auth::user()->name,
          'phone'=>Auth::user()->phone,
          'email'=>Auth::user()->email,
          'user_type'=>Auth::user()->user_type,
          'user_status'=>Auth::user()->user_status,
          'last_login'=>Auth::user()->last_login,
        ];
    }

    public function user(){
        $user = Auth::user();
        return response()->json($user);
    }

    public function register(Request $request){
        $validator              =        Validator::make($request->all(), [
            'name'=>'required',
            'phone'=>'required|unique:users',
            'email'=>'email|unique:users',
            'city'=>'required',
            'thana'=>'required',
            'gender'=>'required',
        ],[
            'phone.unique' => 'Phone Number Already exists',
            'email.unique' => 'Email Already Exists',
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
        try {
            $user=new User();
            $user->name=$request->get('name');
            $user->gender=$request->get('gender');
            $user->phone=$request->get('phone');
            $user->email=$request->get('email');
            $user->city=$request->get('city');
            $user->thana=$request->get('thana');
            $user->details_address=$request->get('address');
            $user->otp=$this->generateOtp();
            $user->save();
            CommonFunction::send_sms($user->phone,"Exchange System OTp: ".$user->otp);
            $message = "otp sent";
            $status = 200;
            $responseCode = 1;

            return response()->json(["status" => "success",'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()],400);
        }
    }

    private function generateOtp(){
        $otp = rand(1000,9999);
        Log::info('otp='.$otp);
        return $otp;
    }

}
