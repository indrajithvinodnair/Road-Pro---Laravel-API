<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//import models 
use App\Models\traffic_crimes;
use App\Models\crimeandpunishment;
use App\Models\userbasicinfo;
use App\Models\vehicleinformation;
use App\Models\vehicledocs;
use App\Models\officialvehicles;
use App\Models\User;

class traffic_crimesController extends Controller

{


    public function logCrime(Request $request)
    {
        $user = new User();
        $oid = $request->officer_id;
        $ocount = $user->ifUserExistsByUserId($oid);
        if ($ocount == 1) {
            $traffic_crime = traffic_crimes::find($request->Id);
            $traffic_crime->infraction_id = (int)$request->infraction_id;
            $traffic_crime->date_issued = $request->date_issued;
            $traffic_crime->status = (int)$request->status;
            $traffic_crime->vehicle_id = $request->vehicle_id;
            $traffic_crime->officer_id = $request->officer_id;
            $traffic_crime->Aadhar = $request->Aadhar;
            $traffic_crime->save();

            return response()->json([
                'status' => 200,
                'message'=> "successfully updated",
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'officer doesnot exist',
            ]);
        }
    }

    public function addTraficCase(Request $request){
        $officer = DB::table('users')->select('uId')->where('userName','=',$request->officerName)->get();
        $officerId = $officer[0]->uId;
         
        $traffic = new traffic_crimes();
        $traffic->infraction_id = (int)$request->infraction_id;
        $traffic->date_issued = $request->date_issued;
        $traffic->status = $request->status;
        $traffic->officer_id = $officerId;
        $traffic->vehicle_id = $request->vehicle_id;
        $traffic->Aadhar = $request->Aadhar;
        $traffic->save();

        return response()->json([
            'status' => 200,
            'message'=> "successfully inserted",
        ]);
    }



    public function getCrimeData($id)
    {
        $id = (int)$id;
        if ($id == -1) {
            $crimeData = DB::table('traffic_crimes')->where('status', '=', 1)->join('officialsinfo', 'traffic_crimes.officer_id', '=', 'officialsinfo.uId')->get();
        } else if ($id == -2) {
            $crimeData = DB::table('traffic_crimes')->join('officialsinfo', 'traffic_crimes.officer_id', '=', 'officialsinfo.uId')->get();
        }
        return response()->json([
            'status' => 200,
            'crimeData' => $crimeData,


        ]);
    }

    public function getInfractions(){
        $infractionList = DB::table('crimeandpunishment')->get();
        return response()->json([
            'status' => 200,
            'message' => "retrival sucessfull",
            'infractions' => $infractionList,
        ]);
    }


    public function closeCrime($id)
    {
        $id = (int)$id;
        $case = traffic_crimes::find($id);
        if ($case) {
            if ($case->status == 0) {
                $case->status = 1;
            } else {
                $case->status = 0;
            }
            $case->save();
            return response()->json([
                "status" => 200,
                "message" => "case status Updated Successfully",

            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => "Unknown case id",

            ]);
        }
    }

    public function deleteInfractions($id){
        $id = (int)$id;
        $infraction = crimeandpunishment::find($id);
        if($infraction){
            $infraction->delete();
            return response()->json([
                "status" => 200,
                "message" => "Infraction Deleted Successfully",

            ]);
        }else{
            return response()->json([
                "status" => 401,
                "message" => "Unknown id",

            ]);
        }
    }

    public function getcrimeStats(){
        $rashdrive= DB::table('traffic_crimes')->where('infraction_id','=',1)->count();
        $drunkanddrive= DB::table('traffic_crimes')->where('infraction_id','=',2)->count();
        $speeding= DB::table('traffic_crimes')->where('infraction_id','=',3)->count();
        return response()->json([
            "status" => 200,
           'rashdrive'=>$rashdrive,
           'drunkanddrive' =>$drunkanddrive,
           'speeding'=>$speeding

        ]);

    }
}
