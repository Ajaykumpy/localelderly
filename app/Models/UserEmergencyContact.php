<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmergencyContact extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','name','mobile','created_by','updated_by'];

}
