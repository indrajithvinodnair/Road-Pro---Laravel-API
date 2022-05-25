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
use App\Models\officialsinfo;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        $userObj = new User();
        $user = User::where('userName', $request->user)->first();
        if ($user) {
            $id = $userObj->getUserId($user->userName);
            $basicInfo = userbasicinfo::where('uId', $id)->first();
            $licenceInfo = userlicenceinfo::where('uId', $id)->first();
            if ($basicInfo && $licenceInfo) {

                return response()->json([
                    "status" => 200,
                    "name" => $user->userName,
                    "firstname" => $basicInfo->firstName,
                    "lastname" => $basicInfo->lastName,
                    "gender" => $basicInfo->gender,
                    "state" => $basicInfo->state,
                    "pin" => $basicInfo->pinCode,
                    "phone" => $basicInfo->phone,
                    "dob" => $basicInfo->dob,
                    "address" => $basicInfo->address,
                ]);
            } else {
                return response()->json([
                    "status" => 401,
                    "message" => "User Not Found"
                ]);
            }
        } else {
            return response()->json([
                "status" => 401,
                "message" => "User Not Found"
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $basicInfo = new userbasicinfo();
        if ($basicInfo) {
            $basicInfo->firstName = $request->firstname;
            $basicInfo->lastName = $request->lastname;
            $basicInfo->dob = $request->dob;
            $basicInfo->address = $request->address;
            $basicInfo->pinCode = $request->pin;
            $basicInfo->state = $request->state;
            $basicInfo->gender = $request->gender;
            $basicInfo->phone = $request->phone;

            return response()->json([
                "status" => 201,
                "message" => "User Update Successfull",
            ]);
        } else {
            return response()->json([
                "status" => 400,
                "message" => "User Update failed",
            ]);
        }
    }

    public function indexCivilan()
    {

        $userList = DB::table('users')->where('userRole', '4')->join('userbasicinfo', 'userbasicinfo.uId', '=', 'users.uId')->join('userlicenceinfo', 'userlicenceinfo.uId', '=', 'users.uId')->get();

        return response()->json([
            'status' => 200,
            'civilanlist' => $userList,
        ]);
    }

    public function viewUsers($value)
    {
        $rolevalue = (int)$value;

        $userList = DB::table('users')->where('userRole', $rolevalue)->join('officialsinfo', 'officialsinfo.uId', '=', 'users.uId')->get();


        if ($userList->isEmpty()) {
            return response()->json([
                'status' => 401,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'userslist' => $userList,
            ]);
        }
    }

    public function getUser($id)
    {
        $id = (int)$id;
        $userList = DB::table('users')->where('users.uId', $id)->join('userbasicinfo', 'userbasicinfo.uId', '=', 'users.uId')->join('userlicenceinfo', 'userlicenceinfo.uId', '=', 'users.uId')->get();
        if ($userList->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' => "Invalid User Id"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "user fetch successful",
                'userslist' => $userList,
            ]);
        }
    }

    
    public function getOwner($aadhar)
    {
        $ownerinfo = DB::table('userbasicinfo')->where('userbasicinfo.aadharNo','=',$aadhar)->join('userlicenceinfo', 'userlicenceinfo.uId', '=', 'userbasicinfo.uId')->get();
        if ($ownerinfo->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' => "Invalid User Id"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "user fetch successful",
                'owner' => $ownerinfo,
            ]);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $id = (int)$id;
        $Users = new User();
        $usertable =  User::find($id);
        $userbasicinfo = userbasicinfo::find($id);
        $userlicenceinfo = userlicenceinfo::find($id);

        $username = $Users->getUserName($id);
        $emailid = $Users->getEmailId($id);
        $unamecount = $Users->ifUserNameExists($request->userName);
        $emailcount = $Users->ifEmailExists($request->email);


        if ($username == $request->userName || $unamecount == 0) {

            if ($emailid == $request->email || $emailcount == 0) {
                $usertable->userName = $request->userName;
                $usertable->email = $request->email;
                $usertable->save();
                $userbasicinfo->firstName = $request->firstName;
                $userbasicinfo->lastName = $request->lastName;
                $userbasicinfo->aadharNo = $request->aadharNo;
                $userbasicinfo->dob = $request->dob;
                $userbasicinfo->gender = $request->gender;
                $userbasicinfo->phone = $request->phone;
                $userbasicinfo->address = $request->address;
                $userbasicinfo->pinCode = $request->pinCode;
                $userbasicinfo->state = $request->state;
                $userbasicinfo->save();
                $userlicenceinfo->licenceNo = $request->licenceNo;
                $userlicenceinfo->save();

                return response()->json([
                    "status" => 200,
                    "message" => "User Information Updated Successfully",

                ]);
            } else {

                return response()->json([
                    "status" => 422,
                    "message" => "Email already Exists",
                ]);
            }
        } else {

            return response()->json([
                "status" => 423,
                "message" => "User Name already Exists",
            ]);
        }
    }

    
    public function verifyUser($id){
        $id = (int)$id;
        $user = User::find($id);
        if($user){
          if($user->userStatus == 0){
            $user->userStatus = 1;
          }else{
            $user->userStatus = 0;
          }
          $user->save();
            return response()->json([
                "status" => 200,
                "message" => "User Status Updated Successfully",

            ]);
        }else{
            return response()->json([
                "status" => 401,
                "message" => "Unknown User",

            ]);

        }
    }


    public function addUser(Request $request)
    {
        $usertable = new User();
        $officaltable = new officialsinfo();

        $ucount = $usertable->ifUserExists($request->username, $request->email);

        if ($ucount == 0) {

            $usertable->userName = $request->username;
            $usertable->password = Hash::make($request->cpassword);
            $usertable->email = $request->email;
            $usertable->userRole = (int)$request->role;
            $usertable->userStatus = $request->status;
            $usertable->save();

            $uid = $usertable->getUserId($request->username);

            $officaltable->uId = $uid;
            $officaltable->firstName = $request->firstname;
            $officaltable->lastName = $request->lastname;
            $officaltable->jurisdiction = $request->jurisdiction;
            $officaltable->station = $request->station;
            $officaltable->phone = $request->phone;
            $officaltable->save();

            // generating token
            $token = $usertable->createToken($request->username . '_token', [''])->plainTextToken;

            
            return response()->json([
                "status" => 201,
                "username" => $usertable->userName,
                "message" => "User Registration Successfull",
                "token" => $token,

            ]);
        } else {
            return response()->json([
                "message" => "user already exists",
                "status" => 400,
            ]);
        }
    }

    public function getOfficialsInfo($id)
    {
        $id = (int)$id;
        $userList = DB::table('users')->where('users.uId', $id)->join('officialsinfo', 'officialsinfo.uId', '=', 'users.uId')->get();
        if ($userList->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' => "Invalid User Id"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "user fetch successful",
                'userslist' => $userList,
            ]);
        }
    }

    public function getOfficialsInfo_two($name)
    {
        $userList = DB::table('users')
        ->where('users.userName', $name)
        ->where('users.userRole','!=',4)
        ->join('officialsinfo', 'officialsinfo.uId', '=', 'users.uId')
        ->select('officialsinfo.uId')->get();
        if ($userList->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' => "Invalid User Name"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "user fetch successful",
                'officerId' => $userList,
            ]);
        }
    }





    public function updateOfficalsInfo(Request $request, $id)
    {
        $id = (int)$id;
        $Users = new User();
        $usertable =  User::find($id);
        $officaltable = officialsinfo::find($id);

        $username = $Users->getUserName($id);
        $emailid = $Users->getEmailId($id);
        $unamecount = $Users->ifUserNameExists($request->userName);
        $emailcount = $Users->ifEmailExists($request->email);
        
        if ($username == $request->userName || $unamecount == 0) {

            if ($emailid == $request->email || $emailcount == 0) {
                $usertable->userName = $request->userName;
                $usertable->email = $request->email;
                $usertable->save();

                $uid = $usertable->getUserId($request->userName);

                $officaltable->uId = $uid;
                $officaltable->firstName = $request->firstName;
                $officaltable->lastName = $request->lastName;
                $officaltable->jurisdiction = $request->jurisdiction;
                $officaltable->station = $request->station;
                $officaltable->phone = $request->phone;
                $officaltable->save();

    
                return response()->json([
                    "status" => 200,
                    "message" => "User Information Updated Successfully",

                ]);
            } else {
                return response()->json([
                    "status" => 422,
                    "message" => "Email already Exists",
                ]);
            }
        } else {
            return response()->json([
                "status" => 423,
                "message" => "User Name already Exists",
            ]);
        }
    }


    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $user->tokens()->where('tokenable_id', $id)->delete();
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
 public function getAadharInfo(){
        $aadharList = DB::table('users')->where('userStatus','=',1)->where('userRole','=',4)->join('userbasicinfo', 'userbasicinfo.uId', '=', 'users.uId')->select('aadharNo')->get();
        if($aadharList){
            return response()->json([
                'status' => 200,
                'aadharlist' => $aadharList,
            ]); 
        }else{
            return response()->json([
                'status' => 401,
                'message' => "Users Doesnt Exist",
            ]);
        }
    }


   public function getUserCount(){
        $Tcount = DB::table('users')->where('userStatus','=',1)->count();
        $civilanCount = DB::table('users')->where('userRole','=',4)->where('userStatus','=',1)->count();
        $rtoCount = DB::table('users')->where('userRole','=',1)->count();
        $civilPoliceCount = DB::table('users')->where('userRole','=',3)->count();
        $trafficPoliceCount = DB::table('users')->where('userRole','=',2)->count();
        return response()->json([
            'status' => 200,
            'totalcount'=>$Tcount,
            'rto' =>  $rtoCount,
            'traffic' => $trafficPoliceCount,
            'civil' =>  $civilPoliceCount,
            'civilians' => $civilanCount,
        ]);
   }

   public function getLicenseStats(){
       $verified=DB::table('userlicenceinfo')->where('licenceStatus','=',0)->count();
       $suspended=DB::table('userlicenceinfo')->where('licenceStatus','=',1)->count();
       return response()->json([
           'status' => 200,
           'active' => $verified,
           'suspended' => $suspended,
       ]);
   }

   public function getUsersAadhar($userName){
   $user= new User();
   $uId=$user->getUserId($userName);
   $userBasicInfo=new UserBasicInfo();
   $AadharNumber=$userBasicInfo->getAadhar($uId);
   if($AadharNumber){
       return response()->json([
           'status' =>200,
           'AadharNumber' =>$AadharNumber,
       ]);
   }
   else{
       return response()->json([
           'status' =>401,
           'message'=>'user not found',
       ]);
   } }
}
