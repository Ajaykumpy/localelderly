<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use \App\Helpers\HasPackageSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_code',
        'mobile',
        'gender','dob','age','height','weight','image',
        'physical_activity_level','allergies','diet_preferences',
        'medical_conditions'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The services that belong to the user.
     */
    public function device()
    {
        return $this->hasOne('App\Models\UserDevices');
    }

    public function profile(){
        //return $this->hasOne(DoctorProfile::class,'doctor_id','id');
		return $this->belongsTo(User::class,'id','mobile');
    }

    public function allergies(){
        return $this->hasOneThrough(allergy::class,UserAllergy::class,'user_id','id','id','allergy_id');
    }

    public function allergy(){
        return $this->belongsToMany(allergy::class,'user_allergies','user_id','allergy_id','id');
    }
    // public function profiledetails()
    // {
    //     return $this->belongsTo(PatientProfile::class,'user_id','id');
    // }


    /*public function getImageAttribute()
    {
        if(!empty($this->image)){
            return $this->image;
        }
        $hash = !empty($this->mobile) ? md5(strtolower(trim($this->mobile))) : '';
        return sprintf('//secure.gravatar.com/avatar/%s?d=mm', $hash);
    }*/
    // public function getDobAttribute(){
    //     if(!empty($this->attributes['dob'])){
    //         return \Carbon\Carbon::parse($this->attributes['dob'])->format('d/m/Y');
    //     }
    //     return $this->attributes['dob'];
    // }

    // public function getAgeAttribute(){
    //     if(!empty($this->attributes['dob'])){
    //         $date = \Carbon\Carbon::createFromFormat('d/m/Y',$this->attributes['dob'])->format('Y-m-d');
    //         return \Carbon\Carbon::parse($date)->age;
    //     }
    //     return $this->attributes['age'];
    // }

}
