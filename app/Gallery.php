<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [ 'name', 'description', 'user_id' ];

    public function user(){

        return $this->belongsTo(User::class);
    }
    public function image(){

        return $this->hasMany(Image::class);
    }
}
