<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    public static function boot(){
        parent::boot();
        static::creating(function($obj){
            $obj->uuid=\Str::uuid()->toString();
        });
    }
}
