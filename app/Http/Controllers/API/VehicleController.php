<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;

//import models 

use App\Models\userbasicinfo;
use App\Models\vehicleinformation;
use App\Models\vehicledocs;
use App\Models\officialvehicles;
use App\Models\User;



class VehicleController extends Controller
{
    public function registerVehicle(Request $request, $id)
    {
        $id = (int)$id;

        $vehicleDoc = new vehicledocs();
        $vehicleInfo = new vehicleinformation();
        $basicInfo = new userbasicinfo();
        // for official vehicles only
        $officialVehicles = new officialvehicles();
        // validating image fields
        $validator = Validator::make($request->all(), [
            'vehicleFront' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'vehicleRear' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'vehicleSideLeft' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'vehicleSideRight' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages(),
            ]);
        } else {
            // checking if user aadhar already exists ?
            $acount = $basicInfo->ifaadharExists($request->aadharNo);
            // bypass aadhar validaton if vehicle is not of registered user
            if ($id == 2 || $id == 3) {
                $acount = 1;
            }

            if ($acount == 1) {
                // checking whether the vehicle exists or not
                $vcount = $vehicleInfo->ifVechicleExists($request->engineNumber, $request->chasisNumber, $request->plateNumber);

                if ($vcount == 0) {
                    $vehicleInfo->aadharNo = $request->aadharNo;
                    $vehicleInfo->plateNumber = $request->plateNumber;
                    $vehicleInfo->engineNumber = $request->engineNumber;
                    $vehicleInfo->regDate = $request->regDate;
                    $vehicleInfo->manDate = $request->manDate;
                    $vehicleInfo->chasisNumber = $request->chasisNumber;
                    $vehicleInfo->modelName     = $request->modelName;
                    $vehicleInfo->vechicleCategory = $request->vechicleCategory;
                    $vehicleInfo->subCategory = $request->subCategory;
                    $vehicleInfo->emissionCategory = $request->emissionCategory;
                    $vehicleInfo->seatingCapacity = (int)$request->seatingCapacity;
                    $vehicleInfo->standingCapacity =  (int)$request->standingCapacity;
                    $vehicleInfo->cyclinderCount =  (int)$request->cyclinderCount;
                    $vehicleInfo->fuelType = $request->fuelType;
                    $vehicleInfo->color = $request->color;
                    $vehicleInfo->vehicleAccess = (int)$request->vehicleAccess;
                    $vehicleInfo->vechicleStatus = (int)$request->vechicleStatus;
                    $vehicleInfo->vehicleCost = (int)$request->vehicleCost;
                    $vehicleInfo->save();

                    $vid = $vehicleInfo->getVehicleIdByEngine($request->engineNumber);
                    $vehicleDoc->vehicleID = $vid;
                    // inserting images
                    if ($request->hasFile('vehicleFront')) {
                        $file = $request->file('vehicleFront');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicleFront', $filename);
                        $vehicleDoc->vehicleFront = 'uploads/vehicleFront/' . $filename;
                    }

                    if ($request->hasFile('vehicleRear')) {
                        $file = $request->file('vehicleRear');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicleRear', $filename);
                        $vehicleDoc->vehicleRear = 'uploads/vehicleRear/' . $filename;
                    }

                    if ($request->hasFile('vehicleSideLeft')) {
                        $file = $request->file('vehicleSideLeft');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicleSideLeft', $filename);
                        $vehicleDoc->vehicleSideLeft = 'uploads/vehicleSideLeft/' . $filename;
                    }

                    if ($request->hasFile('vehicleSideRight')) {
                        $file = $request->file('vehicleSideRight');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicleSideRight', $filename);
                        $vehicleDoc->vehicleSideRight = 'uploads/vehicleSideRight/' . $filename;
                    }
                    
                    $vehicleDoc->save();

                    //inserting data if vehicle is offical 
                    if($id == 3){
                        $officialVehicles->vehicleID = $vid;
                        $officialVehicles->ownership = $request->ownership;
                        $officialVehicles->vehicleUsage = $request->vehicleUsage;
                        $officialVehicles->save();
                    }

                    return response()->json([
                        "status" => 200,
                        "message" => "Vehicle registerd successfully",
                    ]);
                } else {
                    return response()->json([
                        "status" => 401,
                        "message" => "Vehicle Exists"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => 401,
                    "message" => "User Not Found"
                ]);
            }
        }
    }

    // function to get vechicle information
    public function getVehicle($id)
    {
        $id = (int)$id;
        if($id == 3){
            $vehicleList = DB::table('vehicleinformation')->where('vehicleAccess', '=', 3)->join('vehicledocs', 'vehicledocs.vehicleID', '=', 'vehicleinformation.vehicleID')->join('officialvehicles','officialvehicles.vehicleID','=','vehicleinformation.vehicleID')->get();
        }else{

            $vehicleList = DB::table('vehicleinformation')->where('vehicleAccess', '=', $id)->join('vehicledocs', 'vehicledocs.vehicleID', '=', 'vehicleinformation.vehicleID')->get();
        }

        return response()->json([
            'status' => 200,
            'vehiclelist' => $vehicleList,
        ]);
    }


    // funciton to update user vehilcle info

    public function updateUserVehicleInfo(Request $request){
    
        $id = (int)$request->vehicleID;
        $vehicleInfo = vehicleinformation::find($id);
        if($vehicleInfo){
            $vehicleInfo->plateNumber = $request->plateNumber;
            $vehicleInfo->engineNumber = $request->engineNumber;
            $vehicleInfo->regDate = $request->regDate;
            $vehicleInfo->vechicleCategory = $request->vechicleCategory;
            $vehicleInfo->subCategory = $request->subCategory;
            $vehicleInfo->seatingCapacity = (int)$request->seatingCapacity;
            $vehicleInfo->color = $request->color;
            $vehicleInfo->cyclinderCount =  (int)$request->cyclinderCount;
            $vehicleInfo->save();
            return response()->json([
                "status" => 200,
                "message" => "Vehicle Info Updated Successfully",
            ]);

        }else{
            return response()->json([
                "status" => 401,
                "message" => "Vehicle information not found",
            ]);
        }
    

    }


    // funciton to verify vehicle for db
    public function verifyVehicle($id)
    {
        $id = (int)$id;
        $vehicle = vehicleinformation::find($id);
        if ($vehicle) {
            if ($vehicle->vechicleStatus == 0) {
                $vehicle->vechicleStatus = 1;
            } else {
                $vehicle->vechicleStatus = 0;
            }
            $vehicle->save();
            return response()->json([
                "status" => 200,
                "message" => "Vehicle Status Updated Successfully",

            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => "Unknown User",

            ]);
        }
    }

    // delete a vechicle
    public function deleteVehicle($id)
    {
        $vehicle = vehicleinformation::find($id);
        if ($vehicle) {
            $docs = DB::table('vehicledocs')->where('vehicleID', '=', $vehicle->vehicleID)->get();
            $docs = $docs[0];
            $vehicle->delete();
            File::delete(public_path($docs->vehicleFront),public_path($docs->vehicleRear), public_path($docs->vehicleSideRight), public_path($docs->vehicleSideLeft));
            return response()->json([
                'status' => 200,
                'message' => "Delete Successful",
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => "Delete Failed",
            ]);
        }
    }

    // get vehilce information using vehicle id
    public function getVehicleInfo($id,$type)
    {
        $id = (int)$id;
        if($type == 3){
            $vehiclelist = DB::table('vehicleinformation')->join('officialvehicles','officialvehicles.vehicleID','=','vehicleinformation.vehicleID')->where('vehicleinformation.vehicleID', $id)->get();
        }else{
            $vehiclelist = DB::table('vehicleinformation')->where('vehicleID', $id)->get();
        }
        if ($vehiclelist->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' => "Invalid Vehicle Id"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "Info fetch successful",
                'vehiclelist' => $vehiclelist,
            ]);
        }
    }

    // update vehicle information
    public function updateVehicleInfo(Request $request, $id, $type)
    {
        $id = (int)$id;
        $type = (int)$type;
        $vehicleInfo = vehicleinformation::find($id);
        if ($vehicleInfo) {
            $vehicleInfo->plateNumber = $request->plateNumber;
            $vehicleInfo->engineNumber = $request->engineNumber;
            $vehicleInfo->regDate = $request->regDate;
            $vehicleInfo->manDate = $request->manDate;
            $vehicleInfo->chasisNumber = $request->chasisNumber;
            $vehicleInfo->modelName     = $request->modelName;
            $vehicleInfo->vechicleCategory = $request->vechicleCategory;
            $vehicleInfo->subCategory = $request->subCategory;
            $vehicleInfo->emissionCategory = $request->emissionCategory;
            $vehicleInfo->seatingCapacity = (int)$request->seatingCapacity;
            $vehicleInfo->standingCapacity =  (int)$request->standingCapacity;
            $vehicleInfo->cyclinderCount =  (int)$request->cyclinderCount;
            $vehicleInfo->fuelType = $request->fuelType;
            $vehicleInfo->color = $request->color;
            $vehicleInfo->vehicleCost = (int)$request->vehicleCost;

            if($type == 3){
                $officalVehicle = officialvehicles::find($id);
                if($officalVehicle){
                    $officalVehicle->vehicleUsage = $request->vehicleUsage;
                    $officalVehicle->ownership = $request->ownership;
                    $vehicleInfo->save();
                    $officalVehicle->save();
                }else{
                    return response()->json([
                        "status" => 401,
                        "message" => "Vehicle information not found",
                    ]);
                }
            }else{
                
                $vehicleInfo->save();
            }
            return response()->json([
                "status" => 200,
                "message" => "Vehicle Information Updated Successfully",

            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => "Vehicle information not found",
            ]);
        }
    }
    public function getVehicleData(){
        $vehicleCount=DB::table('vehicleinformation')->where('vechicleStatus','=',1)->count();
        $MotorizedTwoWheelers=DB::table('vehicleinformation')->where('vechicleCategory','=','Motorized Two-Wheeler (2W)')->where('vechicleStatus','=',1)->count();
        $FourWheelers=DB::table('vehicleinformation')->where('vechicleCategory','=','Four-wheelers (4W) (personal)') ->orWhere('vechicleCategory','=','Four-wheelers (4W) (inter-para transit)')->where('vechicleStatus','=',1)->count();
        $HeavyDieselVehicle=DB::table('vehicleinformation')->where('vechicleCategory','=','Heavy Diesel vehicle (HDV)')->where('vechicleStatus','=',1)->count();
        $LightCommercialVehicle= DB::table('vehicleinformation')->where('vechicleCategory','=','Light commercial vehicle (LDV)')->where('vechicleStatus','=',1)->count();
        $MotorizedThreeWheelers= DB::table('vehicleinformation')->where('vechicleCategory','=','Motorized Three-Wheeler (3W)')->where('vechicleStatus','=',1)->count();
        $PublicTransport= DB::table('vehicleinformation')->where('vechicleCategory','=','Public transport')->where('vechicleStatus','=',1)->count();

        return response()->json([
             'status' => 200,
            'TotalVehicles' => $vehicleCount,
            'TwoWheels' => $MotorizedTwoWheelers,
            'ThreeWheels' => $MotorizedThreeWheelers,
            'FourWheels' => $FourWheelers,
            'HDV' =>$HeavyDieselVehicle,
            'LCV' =>$LightCommercialVehicle,
            'PublicTransport' => $PublicTransport
        ]);

        


    }

    public function getUsersVehicle($userName) {
        $user=new User();
        $uId=$user->getUserId($userName);
        $userBasicInfo=new UserBasicInfo();
        $aadharNumber=$userBasicInfo->getAadhar($uId);
        if($aadharNumber){
        $vehicleInfo=DB::table('userbasicinfo')
        ->where('userbasicinfo.aadharNo',$aadharNumber)->
        join('vehicleinformation', 'userbasicinfo.aadharNo', '=', 'vehicleinformation.aadharNo')
        ->join('vehicledocs', 'vehicleinformation.vehicleID', '=', 'vehicledocs.vehicleID')
        ->select('engineNumber','modelName','regDate','plateNumber','vehicledocs.vehicleID','vechicleCategory','seatingCapacity','cyclinderCount','color','vehicleFront','vehicleRear','vehicleSideLeft','vehicleSideRight')
        ->get();

        return response()->json([
            "status" => 200,
            "vehicleInfo" => $vehicleInfo,
        ]);
    
        }
        else {
            return response()->json([
                "status" => 401,
                "message" => "user not found",
            ]);
        }
    }


    // function to search vehicle 
    public function searchVehicle($criteria, $item){
        // check criteria and validate

        $column = "";
        if($criteria == "engine"){
            $column = "engineNumber";
        }else if($criteria == "aadhar"){
            $column = "aadharNo";
        }else if($criteria == "chassis"){
            $column = "chasisNumber";
        }else if($criteria == "plate"){
            $column = "plateNumber";
        }

        $vehicle = DB::table('vehicleinformation')->where($column,'=',$item)
        ->where('vechicleStatus','!=',0)
        ->join('vehicledocs', 'vehicledocs.vehicleID', '=', 'vehicleinformation.vehicleID')
        ->get();

        if($vehicle){
            return response()->json([
                "status" => 200,
                "vehicle" => $vehicle,
            ]);
        }else{
            return response()->json([
                "status" => 401,
                "message" => "Vehicle not found",
            ]);
        }
    }

}
