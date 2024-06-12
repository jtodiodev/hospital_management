<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'doctor_name',
        'date',
        'time',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
