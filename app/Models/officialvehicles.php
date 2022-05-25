<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class officialvehicles extends Model
{
    use HasFactory;
    // explicitly defining table name
    protected $table = 'officialvehicles';
    // explicitly defining primary key
    protected $primaryKey = 'vehicleID';
    // timstamp info is not storing
    public $timestamps = false;
    // primary key is not an incrementing integer value
    public $incrementing = false;

    protected $fillable = [
        'vehicleID ',
        'ownership',
        'vehicleUsage',
    ];

    function ifVehicleExists($id){
        $count = DB::table('userlicenceinfo')->select('uId')->where('vehicleID', $id)->get()->count();
        return($count);
    }   

}
