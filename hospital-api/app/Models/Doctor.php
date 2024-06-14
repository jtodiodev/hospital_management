<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $primaryKey = 'licensed_id';

    protected $fillable = [
        'name',
        'gender',
        'age',
        'contactNo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($doctor) {
            $doctor->licensed_id = (string) rand(10000000, 99999999); 
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}