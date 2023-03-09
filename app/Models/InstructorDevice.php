<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorDevice extends Model
{
    use HasFactory;

    protected $table = 'instructor_devices';
    protected $primaryKey='id';

    protected $fillable = ['instructor_id','device_id', 'device_type'];

}
