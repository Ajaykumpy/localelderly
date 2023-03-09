<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyEmployePackage extends Model
{
    use HasFactory;

    protected $table ='company_employee_packages';
    protected $fillable =['package_id','company_name','user_name','user_mobile','user_email','activation_code'];

    public function package()
    {
        return $this->belongsTo(Package::class,'package_id','id');
    }
}
