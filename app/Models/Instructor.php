<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Instructor extends Authenticatable
{
    protected $guard = 'instructors';

    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'pin', 'gender', 'state', 'city', 'registration_number',
        'registration_council', 'registration_year', 'degree', 'college_institute', 'yrs_of_exp',
        'yrs_of_completion', 'specialist', 'image'];
}
