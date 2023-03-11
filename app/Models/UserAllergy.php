<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAllergy extends Model
{
    use HasFactory;

    protected $table = 'user_allergies';
    protected $primaryKey='user_allergy_id';


      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id','allergy_id'];

     /**
      * Get the user that owns the UserAllergy
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }

     public function allergy(): BelongsTo
     {
         return $this->belongsTo(Allergy::class, 'allergy_id', 'id');
     }


}
