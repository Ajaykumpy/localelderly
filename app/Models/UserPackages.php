<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPackages extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'package_id', 'price', 'start_date', 'end_date'];

    /**
     * Get the user associated with the UserPackages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'foreign_key', 'local_key');
    }

}
