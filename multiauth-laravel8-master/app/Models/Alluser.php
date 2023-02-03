<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alluser extends Model
{
    use HasFactory;
    protected $fillable =[
        'firstname','lastname','guardiansname','guardianphone','address','gender','dob','grade','class','phonenumber','email','password',
    ];
}
