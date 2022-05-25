<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class vehicledocs extends Model{
    use HasFactory;
     // explicitly defining table name
     protected $table = 'vehicledocs';
     // explicitly defining primary key
     protected $primaryKey = 'vehicleID';
     // timstamp info is not storing
     public $timestamps = false;
     // primary key is not an incrementing integer value
     public $incrementing = false;
     
     protected $fillable = [
        'vehicleID',
        'vehicleFront',
        'vehicleRear',
        'vehicleSideLeft',
        'vehicleSideRight',
    ];

}

?>