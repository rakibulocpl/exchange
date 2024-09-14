<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = ['image'];
    protected $appends = ['image_url'];


    public function getImageUrlAttribute($value)
    {
        // Default Photo
        $defaultPhotoUrl = url("uploads/default.jpg");

        // Photo from User's account
        $userPhotoUrl = null;
        if (!empty($this->image)) {
            $userPhotoUrl = url($this->image);
        }

        $value = !empty($userPhotoUrl) ? $userPhotoUrl : $defaultPhotoUrl;

        return $value;
    }

}
