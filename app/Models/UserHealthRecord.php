<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHealthRecord extends Model
{
    use HasFactory;

    protected $fillable=['user_id','health_record_id','image'];

    
}
