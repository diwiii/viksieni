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
    protected $fillable = [ 'slug', 'name', 'arrangement', 'description', 'accent_color', 'content' ];

    /**
     * The relationships that should always be loaded.
     * 
     * This points to sizes() method
     *
     * @var array
     */
    // Do we need this?
    // protected $with = ['images'];

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
    
    public function routes()
    {
        return $this->morphToMany(Route::class, 'routable');
    }

    /**
     * Return first image from attached images;
     */
    public function image()
    {
        return $this->images()->first();
        // How about default values if nothing is returned?
    }

    /**
     * Get all of the images for the section.
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
