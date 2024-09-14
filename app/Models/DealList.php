<?php

namespace App\Models;

use App\Http\Controllers\site\CommonFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class DealList extends Model
{
    protected $table = 'deal_list';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }
}
