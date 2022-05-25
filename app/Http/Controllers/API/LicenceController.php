<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//import models 
use App\Models\User;
use App\Models\userbasicinfo;
use App\Models\userlicenceinfo;

class LicenceController extends Controller
{
    public function getCount(){
        $valid = DB::table('userlicenceinfo')->where('licenceStatus','=',0)->count();
        $nvalid = DB::table('userlicenceinfo')->where('licenceStatus','!=',0)->count();
        $all = DB::table('userlicenceinfo')->count();
        return response()->json([
            "status" => 200,
            "valid" => $valid,
            "suspended" => $nvalid,
            "all" => $all,
        ]);
    }


    public function getLicenceInfo($id){
        $id = (int)$id;
        if($id == 2){
            $liceInfo =  DB::table('userlicenceinfo')->join('userbasicinfo','userbasicinfo.uId', '=','userlicenceinfo.uId')->get();
        }else{
            $liceInfo =  DB::table('userlicenceinfo')->where('licenceStatus','=',$id)->join('userbasicinfo','userbasicinfo.uId', '=','userlicenceinfo.uId')->get();
        }
        return response()->json([
            "status" => 200,
            "liceinfo"=>$liceInfo,
        ]);
    }

    public function handleStatus($id){
        $id = (int)$id;
        $licence = userlicenceinfo::find($id);
        if($licence){
            if($licence->licenceStatus == 0){
              $licence->licenceStatus = 1;
            }else{
              $licence->licenceStatus = 0;
            }
            $licence->save();
              return response()->json([
                  "status" => 200,
                  "message" => "Licence Status Updated Successfully",
  
              ]);
          }else{
              return response()->json([
                  "status" => 401,
                  "message" => "Unknown Licence",
  
              ]);
  
          }
    }
}
