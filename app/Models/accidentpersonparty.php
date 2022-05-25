<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accidentpersonparty extends Model
{
    use HasFactory;
    protected $table = 'accidentpersonparty';
    // explicitly defining primary key
    protected $primaryKey = 'accidentId';
    // timstamp info is not storing
    public $timestamps = false;
    // primary key is not an incrementing integer value
    public $incrementing = false;
    
    protected $fillable = [
       'accidentId',
       'victimFirstName',
       'victimLastName',
       'victimAge',
       'damage',
   ];
}
