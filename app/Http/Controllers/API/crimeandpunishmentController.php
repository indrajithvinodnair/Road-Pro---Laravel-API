<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//import models 
use App\Models\crimeandpunishment;


class crimeandpunishmentController extends Controller
{
    public function getCrimeInfo($crime_id)
    {
        // displays the entire crime info
        if($crime_id==-1)
        {
            $crimeinfo=DB::table('crimeandpunishment')->get();
            if($crimeinfo->count()>0)
            {
            return response()->json([
                'status' => 200,
                'crimeinfo'=>$crimeinfo,


            ]);
        }
        else{
            return response()->json([
                'status' => 401,
                'message'=>"error",
            ]);

        }

        }
        // returns crime info of specified crime id
        else if($crime_id!=-1)
        {
            $crimeinfo=DB::table('crimeandpunishment')->where('infraction_id','=',$crime_id)->get();
            if($crimeinfo->count()>0)
            {
                return response()->json([
                    'status' => 200,
                    'crimeinfo'=>$crimeinfo,
    
    
                ]);
            }
            else{
                return response()->json([
                    'status' => 401,
                    'message'=>"crime id not found",
                ]);
    
            }


            

        }


    }
    //updates the crime info
    public function updateCrimeInfo(Request $request,$crime_id)
    {
        $infraction_id=crimeandpunishment::find($crime_id);
        if($infraction_id)
        {
            $infraction_id->punishment_type = $request->punishment_type;
            $infraction_id->punishment_amount = $request->punishment_amount;
            $infraction_id->infraction_name = $request->infraction_name;
            $infraction_id->save();
            
            //$crimeinfo=$this->getCrimeInfo($crime_id);
            

            return response()->json([

                'status' =>200,
                'message' =>'info updated',
               // 'updated crime info'=>$crimeinfo,
            ]);

        }
        else{
            return response()->json([

                'status' =>401,
                'message' =>'crime id not found',
            ]);


        }



    }

    public function addCrime(Request $request,$infraction_id)
    {
        //checking if infraction id existsOr
        $Infraction= new crimeandpunishment();

        $ifInfractionExists=crimeandpunishment::find($infraction_id);
        if(!$ifInfractionExists)
        {
            $Infraction->infraction_id = (int)$infraction_id;
            $Infraction->punishment_type = $request->punishment_type;
            $Infraction->punishment_amount = $request->punishment_amount;
            $Infraction->infraction_name = $request->infraction_name;
            $Infraction->save();

            return response()->json([
                'status' =>200,
                'message' =>'infraction added',
            ]);

        }
        else
        {
            return response()->json([
                'status' =>401,
                'message' =>'infraction exists',
            ]);

        }



    }
}
