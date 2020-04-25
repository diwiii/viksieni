<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageSize extends Model
{
/**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = ['width', 'url'];

    public function image() {
        return $this->belongsTo(Image::class);
    }
}
