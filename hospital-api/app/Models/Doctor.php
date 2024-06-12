<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'doctors';

    // Define the fillable columns
    protected $fillable = [
        'name',
        'specialty', // Add the specialty field
        'contact_number',
        'email',
    ];
}
