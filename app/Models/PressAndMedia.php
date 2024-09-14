<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PressAndMedia extends Model
{
    use SoftDeletes;
    protected $table = 'press_and_media';
    protected $guarded = ['id'];
}
