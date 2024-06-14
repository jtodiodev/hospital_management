<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'gender',
        'address',
        'contactNo',
        'schedule',
        'doctor_id',
        'doctor_name',
    ];

    protected $primaryKey = 'id'; // Define the primary key

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($schedule) {
            $schedule->id = (string) rand(10000000, 99999999); // Generate a random ID
        });
    }
}