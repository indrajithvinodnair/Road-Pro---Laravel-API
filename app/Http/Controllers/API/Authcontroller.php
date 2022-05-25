<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


//import models 
use App\Models\User;
use App\Models\userbasicinfo;
use App\Models\userlicenceinfo;

class Authcontroller extends Controller
{
    public function register(Request $request)
    {

        $usertable = new User();
        $userbasicinfo = new userbasicinfo();
        $userlicenceinfo = new userlicenceinfo();

        // checking if user already exists
        $ucount = $usertable->ifUserExists($request->username, $request->email);
        // checking if aadahr card alredy exists
        $acount = $userbasicinfo->ifaadharExists($request->aadhar);
        // checking if licence alredy exists
        $lcount = $userlicenceinfo->ifLicenceExists($request->licence);

        if ($ucount == 0 && $acount == 0 && $lcount == 0) {
            $usertable->userName = $request->username;
            $usertable->password = Hash::make($request->cpassword);
            $usertable->email = $request->email;
            $usertable->userRole = $request->role;
            $usertable->userStatus = $request->status;
            $usertable->save();

            $uid = $usertable->getUserId($request->username);

            $userbasicinfo->uId = $uid;
            $userbasicinfo->firstName = $request->firstname;
            $userbasicinfo->lastName = $request->lastname;
            $userbasicinfo->aadharNo = $request->aadhar;
            $userbasicinfo->dob = $request->dob;
            $userbasicinfo->gender = $request->gender;
            $userbasicinfo->phone = $request->phone;
            $userbasicinfo->address = $request->address;
            $userbasicinfo->pinCode = $request->pin;
            $userbasicinfo->state = $request->state;
            $userbasicinfo->save();

            $userlicenceinfo->uId = $uid;
            $userlicenceinfo->licenceNo = $request->licence;
            $userlicenceinfo->licenceStatus = $request->licencestatus;
            $userlicenceinfo->save();


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

    public function validateEmail(Request $request){
        $user = DB::table('users')->select('email','password','uId')->where('email', $request->user)->first();
        if($user){
            return response()->json([
                "status" => 200,
                "user" => $user,
            ]);
        }else{
            return response()->json([
                "status" => 401,
            ]);
        }
    }

    public function validateUser($id){
        $id = (int)$id;
        $user = DB::table('users')->select('userName','password')->where('uId', $id)->first();
        if($user){
            return response()->json([
                "status" => 200,
                "user" => $user,
            ]);
        }else{
            return response()->json([
                "status" => 401,
            ]);
        }
    }



    public function login(Request $request)
    {



        $user = User::where('email', $request->user)->orwhere('userName', $request->user)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => 401,
                "message" => "Invalid credentials"
            ]);
        } else {


            if ($user->userRole == 0) { // 0 -> admin value
                $role = 'admin';
                $token = $user->createToken($user->userName . '_Admintoken', ['server-admin'])->plainTextToken;
            } else if($user->userRole == 4){
                $role = 'user'; // assigned directly, use database table for role identification ; modifiable
                // generating token
                $token = $user->createToken($user->userName . '_token',['server-user'])->plainTextToken;
            }else if($user->userRole == 1){
                $role = 'rto'; 
                $token = $user->createToken($user->userName . '_token',['server-rto'])->plainTextToken;
            }else if($user->userRole == 2){
                $role = 'traffic'; 
                $token = $user->createToken($user->userName . '_token',['server-traffic'])->plainTextToken;
            }else if($user->userRole == 3){
                $role = 'civil'; 
                $token = $user->createToken($user->userName . '_token',['server-civil'])->plainTextToken;
            }else{
                $token = $user->createToken($user->userName . '_token',[''])->plainTextToken;
            }
            return response()->json([
                "status" => 200,
                "message" => "Login Successfull",
                "username" => $user->userName,
                "token" => $token,
                "role" => $role,
            ]);
        }
    }

    public function logout()
    {

        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 200,
            "message" => "Logout Successfull",
        ]);
    }
}
