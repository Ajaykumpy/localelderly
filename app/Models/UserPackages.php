<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackages extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'package_id', 'price', 'start_date', 'end_date'];

}
