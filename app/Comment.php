<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text', 'user_id', 'gallery_id'];

    public function gallery(){

        return $this->belongsTo(Gallery::class);
    }
    public function user(){

         return $this->belongsTo(User::class);
    }
}
