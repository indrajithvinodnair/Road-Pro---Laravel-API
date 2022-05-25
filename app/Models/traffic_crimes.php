<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class traffic_crimes extends Model
{
    use HasFactory;
    // explicitly defining table name
    protected $table = 'traffic_crimes';
    // explicitly defining primary key
    protected $primaryKey = 'Id';
    public $incrementing = true;
     // timstamp info is  storing
     public $timestamps = true;

      // all columns of the table except auto incremented
    protected $fillable = [
        'infraction_id',                   
        'date_issued',
        'created_at',
        'created_at',
        'status',
        'vehicle_id',
        'officer_id',
        'Aadhar',
    ];
}
