<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//import models 
use App\Models\User;
use App\Models\userbasicinfo;
use App\Models\userlicenceinfo;
use App\Models\officialsinfo;
use App\Models\theftInformation;
use App\Models\vehicleinformation;
use App\Models\accidentinfo;
use App\Models\accidentdocs;
use App\Models\accidentpersonparty;
use App\Models\accidentvehicleparty;


class CrimeController extends Controller
{
    public function registerTheft(Request $request)
    {

        $vid = $request->vid;
        $oid = $request->oid;
        $date = $request->date;
        $user = new User();
        $vehicle = new vehicleinformation();
        $vcount = $vehicle->ifVehicleExistsById($vid);
        $ocount = $user->ifUserExistsByUserId($oid);
        if ($vcount === 1 && $ocount === 1) {
            $theft = new theftInformation();
            $theft->officerId = $oid;
            $theft->vehicleID = $vid;
            $theft->reportDate = $date;
            $theft->crimeStatus = 0;
            $theft->save();
            return response()->json([
                "message" => "Successfully logged",
                "status" => 200,
            ]);
        } else {
            return response()->json([
                "message" => "Not Found",
                "status" => 401,
            ]);
        }
    }

    public function checkLogged($id)
    {
        $id = (int)$id;
        $vehicle = DB::table('theftinformation')->where('vehicleID', $id)->where('crimeStatus', '=', 0)->get();
        if (count($vehicle) > 0) {
            return response()->json([
                "message" => "vehicle is logged",
                "status" => 200,
            ]);
        } else {
            return response()->json([
                "message" => "vehicle is not logged",
                "status" => 401,
            ]);
        }
    }

    public function indexCase($id)
    {
        $id = (int)$id;
        $caselist = DB::table('theftinformation')->where('crimeStatus', '=', $id)
            ->join('officialsinfo', 'officialsinfo.uId', '=', 'theftinformation.officerId')
            ->join('vehicleinformation', 'vehicleinformation.vehicleID', '=', 'theftinformation.vehicleID')
            ->join('vehicledocs', 'vehicledocs.vehicleID', '=', 'vehicleinformation.vehicleID')->get();
        return response()->json([
            "caselist" => $caselist,
            "status" => 200,
        ]);
    }

    public function countTheft()
    {
        $countlist = [];
        $countlist[0] = DB::table('theftinformation')->count();
        $countlist[1] = DB::table('theftinformation')->where('crimeStatus', '=', 1)->count();
        $countlist[2] = DB::table('theftinformation')->where('crimeStatus', '=', 0)->count();
        return response()->json([
            "countlist" => $countlist,
            "status" => 200,
        ]);
    }

    public function indexAccident($type)
    {
        if ($type == 1) {
            $caselist = DB::table('accidentinfo')->where('accidentType', '=', $type)->join('accidentvehicleparty', 'accidentinfo.accidentId', '=', 'accidentvehicleparty.accidentId')->join('accidentdocs', 'accidentinfo.accidentId', '=', 'accidentdocs.accidentId')->join('vehicleinformation', 'vehicleinformation.vehicleID', '=', 'accidentinfo.vehicleID')->join('officialsinfo', 'officialsinfo.uId', '=', 'accidentinfo.officerId')->get();
        } else if ($type == 2) {
            $caselist = DB::table('accidentinfo')->where('accidentType', '=', $type)->join('accidentdocs', 'accidentinfo.accidentId', '=', 'accidentdocs.accidentId')->join('vehicleinformation', 'vehicleinformation.vehicleID', '=', 'accidentinfo.vehicleID')->join('officialsinfo', 'officialsinfo.uId', '=', 'accidentinfo.officerId')->join('accidentpersonparty', 'accidentinfo.accidentId', '=', 'accidentpersonparty.accidentId')->get();
        }
        return response()->json([
            "caselist" => $caselist,
            "status" => 200,
        ]);
    }

    public function countAccident()
    {
        $countlist = [];
        $countlist[0] = DB::table('accidentinfo')->count();
        $countlist[1] = DB::table('accidentinfo')->where('accidentType', '=', 1)->count();
        $countlist[2] = DB::table('accidentinfo')->where('accidentType', '=', 2)->count();
        return response()->json([
            "countlist" => $countlist,
            "status" => 200,
        ]);
    }

    public function updateTheftCaseStatus($id)
    {
        $id = (int)$id;
        $case = theftInformation::find($id);
        if ($case) {
            if ($case->crimeStatus == 0) {
                $case->crimeStatus = 1;
            } else if ($case->crimeStatus == 1) {
                $case->crimeStatus = 0;
            }
            $case->save();
            return response()->json([
                "message" => "Case Status Updated Successfully",
                "status" => 200,
            ]);
        } else {
            return response()->json([
                "message" => "Case is not logged",
                "status" => 401,
            ]);
        }
    }

    public function getRegOwner($aadhar)
    {
        $user = DB::table('userbasicinfo')->where('aadharNo', '=', $aadhar)->get();
        if (count($user) > 0) {
            return response()->json([
                "owner" => $user,
                "status" => 200,
            ]);
        } else {
            return response()->json([
                "message" => "Owner Data Not Found",
                "status" => 401,
            ]);
        }
    }

    public function getOfficialOwner($id)
    {
        $id = (int)$id;
        $user = DB::table('officialvehicles')->where('vehicleID', '=', $id)->get();
        if (count($user) > 0) {
            return response()->json([
                "owner" => $user,
                "status" => 200,
            ]);
        } else {
            return response()->json([
                "message" => "Owner Data Not Found",
                "status" => 401,
            ]);
        }
    }

    public function registerAccident($type, Request $request)
    {
        $type = (int)$type;
        // validating image fields
        $validator = Validator::make($request->all(), [
            'accidentPic1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'accidentPic2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages(),
            ]);
        } else {
            $accident = new accidentinfo();
            $accident->vehicleID = $request->vehicleID;
            $accident->officerId = $request->officerId;
            $accident->date = $request->date;
            $accident->cause = $request->cause;
            $accident->place = $request->place;
            $accident->primaryInfo = $request->primaryInfo;
            $accident->accidentType = $type;
            $accident->Save();
            $id = $accident->getAccidentId($request->vehicleID, $request->date);
            if ($type == 1) {
                $victim = new accidentvehicleparty();
                $victim->accidentId = $id;
                $victim->plateNo = $request->plateNo;
                $victim->ownerFirst = $request->ownerFirst;
                $victim->ownerLast = $request->ownerLast;
                $victim->damage = $request->damage;
                $victim->save();
            } else if ($type == 2) {
                $victim = new accidentpersonparty();
                $victim->accidentId = $id;
                $victim->victimFirstName = $request->victimFirstName;
                $victim->victimLastName = $request->victimLastName;
                $victim->victimAge = $request->victimAge;
                $victim->damage = $request->damage;
                $victim->save();
            }

            $accidentDoc = new accidentdocs();
            $accidentDoc->accidentId = $id;
            if ($request->hasFile('accidentPic1')) {
                $file = $request->file('accidentPic1');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/accident', $filename);
                $accidentDoc->accidentPic1 = 'uploads/accident/' . $filename;
            }

            if ($request->hasFile('accidentPic2')) {
                $file = $request->file('accidentPic2');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/accident', $filename);
                $accidentDoc->accidentPic2 = 'uploads/accident/' . $filename;
            }

            $accidentDoc->save();
            return response()->json([
                "status" => 200,
                "message" => "Incident Logged successfully",
            ]);
        }
    }

    public function searchVehicleCases($criteria, $item)
    {
        // check criteria and validate

        $column = "";
        if ($criteria == "engine") {
            $column = "engineNumber";
        } else if ($criteria == "aadhar") {
            $column = "aadharNo";
        } else if ($criteria == "chassis") {
            $column = "chasisNumber";
        } else if ($criteria == "plate") {
            $column = "plateNumber";
        }



        $vobj = new vehicleinformation();

        $aadhar = DB::table('vehicleinformation')->select('aadharNo')->where($column, '=', $item)
            ->where('vechicleStatus', '!=', 0)->get();
        $aadhar = $aadhar[0]->aadharNo;
        $vId = $vobj->getVehicleId($aadhar);



        $accident = DB::table('accidentinfo')->where('accidentinfo.vehicleID', '=', $vId)->join('accidentdocs', 'accidentinfo.accidentId', '=', 'accidentdocs.accidentId')->join('officialsinfo', 'officialsinfo.uId', '=', 'accidentinfo.officerId')
            ->join('vehicleinformation', 'vehicleinformation.vehicleID', '=', 'accidentinfo.vehicleID')
            ->join('vehicledocs', 'vehicledocs.vehicleID', '=', 'vehicleinformation.vehicleID')->get();

        $theft = DB::table('theftinformation')->where('theftinformation.vehicleID', '=', $vId)->join('officialsinfo', 'officialsinfo.uId', '=', 'theftinformation.officerId')->join('vehicleinformation', 'vehicleinformation.vehicleID', '=', 'theftinformation.vehicleID')->join('vehicledocs', 'vehicledocs.vehicleID', '=', 'vehicleinformation.vehicleID')->get();


        if ($accident || $theft) {
            return response()->json([
                "status" => 200,
                "accident" => $accident,
                "theft" => $theft,
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" => "Cases not found",
            ]);
        }
    }
}
