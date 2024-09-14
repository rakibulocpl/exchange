<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

function checkPermission($module,$feature =null){
    if(Auth::user()->permissions ==null || Auth::user()->permissions == ''){
        $permissions = [];
    }else{
        $permissions =  json_decode(Auth::user()->permissions,true);
    }
   if (array_key_exists($module,$permissions)){
       if ($feature){
           return in_array($feature,$permissions[$module]);
       }
     return true;
   }else{
       return false;
   }
}
function getCategory(){
    return Category::with('children')->where('parent_id',0)->get();
}


function isAdmin(){
    $user_type =  Auth::user()->user_type;
    if($user_type == "superman"){
        return true;
    }else{
        return false;
    }

}

function getList($sql)
{
    $values = Array();
    $i = 0;
    if (strtoupper(substr($sql . '      ', 0, 7)) == 'SELECT ' && strpos(';', $sql) <= 1) {
        $rs = DB::select($sql);
        $fields = array_keys((array)$rs[0]);
        if (count($fields) > 1) $i = 1;
        foreach ($rs as $row) {
            $values[$row->$fields[0]] = $row->$fields[$i];
        }
    } else {
        $val = explode(',', $sql);
        for ($i = 0; $i < count($val); $i++) {
            $values[$val[$i]] = $val[$i];
        }
    }
    $data = collect($values);
    return $data;
}



