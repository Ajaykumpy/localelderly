<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory, SoftDeletes;
  /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'batches';
     protected $primaryKey='id';


      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

}
