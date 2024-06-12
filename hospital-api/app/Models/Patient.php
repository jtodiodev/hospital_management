<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'patients';

    // Define the fillable columns
    protected $fillable = [
        'name',
        'age',
        'phone_number',
        'address',
    ];
}
