<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class vehicleinformation extends Model{
    use HasFactory;
     // explicitly defining table name
     protected $table = 'vehicleinformation';
     // explicitly defining primary key
     protected $primaryKey = 'vehicleID';
     // timstamp info is not storing
     public $timestamps = false;
     // primary key is an incrementing integer value
     public $incrementing = true;
     
     protected $fillable = [
        'vehicleID',
        'aadharNo',
        'plateNumber',
        'engineNumber',
        'regDate',
        'manDate',
        'chasisNumber',
        'modelName',
        'vechicleCategory',
        'subCategory',
        'emissionCategory',
        'seatingCapacity',
        'standingCapacity',
        'cyclinderCount',
        'fuelType',
        'color',
        'vehicleAccess',
        'vechicleStatus',
        'vehicleCost',
    ];

    
    function ifVechicleExists($engineNumber,$chasisNumber,$plateNumber){
        $count = DB::table('vehicleinformation')->select('vehicleID')->where('engineNumber', $engineNumber)->orWhere('chasisNumber',$chasisNumber)->orWhere('plateNumber',$plateNumber)->get()->count();
        return($count);
    }   

    function getVehicleId($aadhar) {
        $vehicleID = DB::table('vehicleinformation')->select('vehicleID')->where('aadharNo',$aadhar)->get();
        $vehicleID = $vehicleID[0]->vehicleID;
        return($vehicleID);
    }

    function getVehicleIdByEngine($engine) {
        $vehicleID = DB::table('vehicleinformation')->select('vehicleID')->where('engineNumber',$engine)->get();
        $vehicleID = $vehicleID[0]->vehicleID;
        return($vehicleID);
    }

    
    function ifVehicleExistsById($vid){
        $vid = (int)$vid;
        $count = DB::table('vehicleinformation')->select('vehicleID')->where('vehicleID',$vid)->get()->count();
        return($count);
    }

}

?>