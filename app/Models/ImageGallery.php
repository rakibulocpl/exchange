<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageGallery extends Model
{
    protected $table = 'image_gallery';
    protected $guarded = ['id'];
}
