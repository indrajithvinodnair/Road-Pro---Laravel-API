<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class crimeandpunishment extends Model
{
    use HasFactory;
    // explicitly defining table name
    protected $table = 'crimeandpunishment';
    // explicitly defining primary key
    protected $primaryKey = 'infraction_id';
    // timstamp info is not storing
    public $timestamps = false;
    
    public $incrementing = false;

    protected $fillable = [
        'infraction_id',
        'punishment_type',                   // all columns of the table except auto incremented
        'punishment_amount',
        'Infraction_name',
    ];

}
