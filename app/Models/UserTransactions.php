<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransactions extends Model
{
    use HasFactory;
    protected $fillable = ['package_subscriptions_id',	'subscriber_id',	'package_id',	'payment_id',	'created_at',	'updated_at',
                            'title', 'status','price','payment_log'];

    public function user(){
        return $this->belongsTo(User::class,'subscriber_id','id')->withTrashed();
    }
}

		
