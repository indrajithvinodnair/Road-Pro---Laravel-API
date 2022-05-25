<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class userbasicinfo extends Model
{
    use HasFactory;
    
    protected $table = 'userbasicinfo';
    // explicitly defining primary key
    protected $primaryKey = 'uId';
    // no incremental primary key
    public $incrementing = false;
    // no timestamp configuration
    public $timestamps = false;

    protected $fillable = [
        'uId',
        'firstName',
        'lastName',
        'aadharNo',
        'dob',
        'gender',
        'phone',
        'address',
        'pinCode',
        'state',
    ];

     function ifaadharExists($aadhar){
        $count = DB::table('userbasicinfo')->select('uId')->where('aadharNo',$aadhar)->get()->count();
        return($count);
    }

    function getUserId($aadhar) {
        $uid = DB::table('userbasicinfo')->select('uId')->where('aadharNo',$aadhar)->get();
        $uid = $uid[0]->uId;
        return($uid);
    }

    function getAadhar($uId){
        $AadharNumber = DB::table('userbasicinfo')->select('aadharNo')->where('uId',$uId)->get();
        $AadharNumber = $AadharNumber[0]->aadharNo;
        return($AadharNumber);
       }
    

}
