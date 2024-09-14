<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\site\CommonFunction;
use App\Http\Requests\RegisterRequest;
use App\Models\CityList;
use App\Models\GenderList;
use App\Models\ThanaList;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request){
        return view('userPanel.auth.login');
    }

    public function sendotp(Request $request){
        Session::forget('usermobile');
        $mobileno = $request->get('mobileno');
        $user =User::where('phone',$mobileno)->first();

        if ($user){
            $user->otp = $this->generateOtp();
            $user->save();
             CommonFunction::send_sms($mobileno,"ExchangeKori OTP= ".$user->otp);
            $message = "otp sent";
            $responseCode = 1;
            $is_register = 1;
            $status = 200;
            Session::put('usermobile', $mobileno);
        }else {
            $status = 200;
            $responseCode = 1;
            $is_register = 0;
            $otp = $this->generateOtp();
            CommonFunction::send_sms($mobileno,"Systemeye Exchange OTP= ".$otp);
            $message = "otp sent".$otp;
            Session::put('usermobile', $mobileno);
            Session::put('userotp', $otp);
        }

        return response()->json(['message'=>$message,'registerStatus'=>$is_register,'responseCode'=>$responseCode]);
    }

    public function verifyOtpView(Request $request){
        if (Session::has('usermobile')){
            return view('userPanel.verifyOtpView');
        }else{
            return redirect()->to('/');
        }

    }

    public function veirfyOtp(Request $request){
        try {
            $user = User::where('phone',$request->get('mobileno'))->where('otp',$request->get('otp'))->first();
            DB::beginTransaction();
            if($user){
                Auth::login($user);
                $user->otp = null;
                $user->last_login = Carbon::now();
                $user->save();
                /* @var User $user*/
                $user = Auth::user();
                Auth::loginUsingId($user->id);
                Session::forget('usermobile');
                $userdata = $this->userAuthData();
                DB::commit();
                return response()->json(['status'=>1,'user'=>$userdata],200);
            }else if (Session::get('userotp') == $request->get('otp')){
                $user=new User();
                $user->phone= $request->get('mobileno');
                $user->last_login = Carbon::now();
                $user->otp = Session::get('userotp');
                $user->save();
                Auth::login($user);
                /* @var User $user*/
                $user = Auth::user();
                Auth::loginUsingId($user->id);
                $userdata = $this->userAuthData();
                DB::commit();
                return response()->json(['status'=>1,'user'=>$userdata,'message'=>'Validation successfully Done']);
            }else{
                return response()->json(['status'=>-1,'message'=>'Invalid OTP']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>-1,'message'=>'Invalid OTP']);
        }

    }

    private function userAuthData (){
        return [
          'name'=>Auth::user()->name,
          'phone'=>Auth::user()->phone,
          'email'=>Auth::user()->email,
          'city'=>Auth::user()->city,
        ];
    }

    public function user(){
        $user = Auth::user();
        return response()->json($user);
    }

    public function thanaListByCity($cityId){
        $gender  = ThanaList::where('status',1)
            ->where('city_id',$cityId)
            ->get(['id','thana_name as display'])->toArray();
        return response()->json($gender);
    }
    public function registerView(){
        $gender  = GenderList::where('status',1)->pluck('gender_name as display','id')->toArray();
        $city  = CityList::where('status',1)->pluck('city_name as display','id')->toArray();
        return view('userPanel.register',compact('city','gender'));
    }

    public function register(Request $request){
        $validator              =        Validator::make($request->all(), [
            'fname'=>'required',
            'lname'=>'required',
            'phone'=>'required|unique:users',
            'email'=>'email|unique:users',
            'city'=>'required',
            'thana'=>'required',
            'gender'=>'required',
        ],[
            'phone.unique' => 'Phone Number Already exists',
            'email.unique' => 'Email Already Exists',
        ]);
        $validator->validate();
        Session::forget('usermobile');
        try {
            $user=new User();
            $user->name=$request->get('fname').''.$request->get('lname');
            $user->gender=$request->get('gender');
            $user->phone=$request->get('phone');
            $user->email=$request->get('email');
            $user->city=$request->get('city');
            $user->thana=$request->get('thana');
            $user->details_address=$request->get('address');
            $user->otp=$this->generateOtp();
            $user->save();
            Session::put('usermobile', $user->phone);
            CommonFunction::send_sms($user->phone,"Exchange System OTp: ".$user->otp);
            $message = "otp sent";
            $status = 200;
            $responseCode = 1;

            return redirect()->to('verify-otp');

        }catch (\Exception $e){
            return redirect()->back();
        }
    }

    private function generateOtp(){
        $otp = rand(1000,9999);
        Log::info('otp='.$otp);
        return $otp;
    }

}
