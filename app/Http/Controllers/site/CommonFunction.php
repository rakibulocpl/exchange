<?php

namespace App\Http\Controllers\site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class CommonFunction extends Controller
{
    public static function getBranchCode(){

        $branchcode = Auth::user()->branch_id;
        return $branchcode;
    }


    public static function getUserId()
    {

        if (Auth::user()) {
            return Auth::user()->id;
        } else {
            return 'Invalid Login Id';
        }
    }

    public static function send_sms_with_mask($number,$text) {
        $url = "http://66.45.237.70/api.php";
        $data= array(
            'username'=>"stl2",
            'password'=>"M8XYCVRT",
            'number'=>"$number",
            'message'=>"$text"
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST =>0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function send_sms($number,$text) {
        $url = "http://103.53.84.15/sendtext?";
        $callerId = 'SystemEye';
        if (strpos($number,'88') !== 0){
            $number = '88'.$number;
        }
        if (strpos($number,'88017') === 0 || strpos($number,'88013') ===0){
            $callerId = 'SystemEyeIT';
        }

        $data= array(
            'apikey'=>"4dc860f3edf9bfbb",
            'secretkey'=>"316be930",
            'callerID'=>"$callerId",
            'toUser'=>"$number",
            'messageContent'=>"$text"
        );
        $queryParam = http_build_query($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8746",
            CURLOPT_URL => $url.$queryParam,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST =>FALSE,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}