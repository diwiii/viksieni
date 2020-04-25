<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = [ 'slug', 'name', 'arrangement', 'image_id', 'description', 'accent_color', 'content' ];

    /**
     * Atrod Modeli pēc slug colonas , default ir pēc primaryKey tas ir ID
     * Pārraksta defaulto getRouteKeyName funkciju
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * Func that returns path of the model
     */
    public function path() {
        return route('section.show', $this);
    }
    
    // Get the image
    // How about default values if nothing is returned?
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
