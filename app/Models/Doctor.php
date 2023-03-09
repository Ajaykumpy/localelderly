<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable;
	use HasWallet;
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'pin', 'mobile', 'pin', 'gender', 'state', 'city', 'registration_number',
        'registration_council', 'registration_year', 'degree', 'college_institute', 'yrs_of_exp',
        'yrs_of_completion', 'specialist', 'image','salutation'];
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

    public function getdoctor(){
        return $this->belongsTo(DoctorDevice::class,'id','doctor_id')->withTrashed();
    }

    public function current_status(){
        return $this->hasOne(DoctorStatus::class,'doctor_id','id')->orderBy('id', 'desc');//to do
    }

    public function device(){
        return $this->belongsTo(DoctorDevice::class,'doctor_id','id');
    }

    //  public function profile(){
    //     return $this->hasOne(DoctorEducation::class,'doctor_id','id');
    // }

    public function profile(){
        //return $this->hasOne(DoctorProfile::class,'doctor_id','id');
		return $this->belongsTo(DoctorProfile::class,'id','doctor_id');
    }
    /*public function Specialist(){
        return $this->hasOne(Speciality::class,'id','specialist');
    }*/
    // public function doctor_transaction(){
	// 	return $this->belongsTo(Transaction::class,'payable_id','id');
	// }
    public function patient(){
		return $this->belongsTo(User::class,'user_id','id')->withTrashed();
	}
	public function education(){
		return $this->hasOne(DoctorEducation::class,'doctor_id','id');
	}
	public function educations(){
		return $this->hasMany(DoctorEducation::class,'doctor_id','id');
	}
	public function doctor_type(){
        return $this->belongsTo(DoctorType::class,'id','doctor_id');
    }

	public function specialist(){
        return $this->hasOneThrough(Speciality::class,DoctorSpecialist::class,'doctor_id','id','id','specialist_id');
    }

    public function specialists(){
        return $this->belongsToMany(Speciality::class,'doctor_specialists','doctor_id','specialist_id','id');
    }
   

	public static function boot(){
        parent::boot();
        static::creating(function($obj){
            $obj->uuid=\Str::uuid()->toString();
        });
    }



}
