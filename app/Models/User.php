<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'userName',
        'email',
        'password',
        'userRole',
        'userStatus',
    ];

    // primary key of the table
    protected $primaryKey = 'uId';

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    function getUserId($username){
        $uid = DB::table('users')->select('uId')->where('userName',$username)->get();
        $uid = $uid[0]->uId;
        return($uid);
    }
    // if user exists function

    function ifUserExists($username,$email){
        $count = DB::table('users')->select('uId')->where('userName',$username)->orwhere('email',$email)->get()->count();
        return($count);
    }

    
    function ifUserExistsByUserId($uId){
        $uId = (int)$uId;
        $count = DB::table('users')->select('uId')->where('uId',$uId)->get()->count();
        return($count);
    }

   function getUserName($uId){
    $username = DB::table('users')->select('userName')->where('uId',$uId)->get();
    $username = $username[0]->userName;
    return($username);
   }


   function getEmailId($uId){
    $email = DB::table('users')->select('email')->where('uId',$uId)->get();
    $email = $email[0]->email;
    return($email);
   }

   function ifUserNameExists($userName){
    $count = DB::table('users')->select('uId')->where('userName',$userName)->get()->count();
    return($count);
   }

   function ifEmailExists($email){
    $count = DB::table('users')->select('uId')->where('email',$email)->get()->count();
    return($count);
   }

}
