<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingTrack extends Model
{
    protected $table = 'training_track';
    protected $guarded = ['course_id'];
}
