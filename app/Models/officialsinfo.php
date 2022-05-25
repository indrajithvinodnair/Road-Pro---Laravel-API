<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class officialsinfo extends Model
{
    use HasFactory;
     // explicitly defining table name
     protected $table = 'officialsinfo';
     // explicitly defining primary key
     protected $primaryKey = 'uId';
     // timstamp info is not storing
     public $timestamps = false;
     // primary key is not an incrementing integer value
     public $incrementing = false;

     protected $fillable = [
         'uId',
         'firstName',
         'lastName',
         'jurisdiction',
         'station',
         'phone',
     ];


     function ifOfficialExists($uId){
         $count = DB::table('officialsinfo')->where('uId', $uId)->get()->count();
         return($count);
     }   
}
