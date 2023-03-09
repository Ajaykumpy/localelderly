<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory, SoftDeletes;
  /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'allergies';
     protected $primaryKey='id';
 

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

}
