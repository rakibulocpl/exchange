<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentDetails extends Model
{
   protected $table = 'component_details';
   protected $fillable = ['component_id','details','addition_price','status'];
}
