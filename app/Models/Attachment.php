<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attachment extends Model {

    protected $table = 'attachment_list';
    protected $fillable = array(
        'id',
        'doc_name',
        'doc_priority',
        'is_multiple',
        'order',
        'status',
        'is_active',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    );

    public static function boot() {
        parent::boot();
        // Before update
        static::creating(function($post) {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function($post) {
            $post->updated_by = Auth::user()->id;
        });
    }
    /*********************************************End of Model Class**********************************************/
}
