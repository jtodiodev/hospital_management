<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'medical_record';
    protected $fillable = ['name', 'age', 'diagnosis', 'date'];
}

