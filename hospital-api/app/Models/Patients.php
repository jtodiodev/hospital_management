<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $primaryKey = 'caseNo';


    protected $fillable = [
        'caseNo',
        'patient_ID',
        'name',
        'gender',
        'age',
        'contactNo',
    ];

    protected $keyType = 'tring';

    public $incrementing = false;

    public function getRouteKeyName()
    {
        return 'caseNo';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'id');
    }
}