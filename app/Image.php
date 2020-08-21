<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    /**
     * Enable soft deletes trait
     */
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = ['url', 'name', 'description'];

    /**
     * The relationships that should always be loaded.
     * 
     * This points to sizes() method
     *
     * @var array
     */
    protected $with = ['sizes'];

    /**
     * Get the Image sizes from database
     * 
     * $image->sizes
     */
    public function sizes() {
        //vajag pamēģināt arī hasMany(Product::class) 
        return $this->hasMany(ImageSize::class, 'image_id'); // select * from sizes where image_id = 
    }

    /**
     * Get all of the sections that are assigned this image.
     */
    public function sections() {
        return $this->morphedByMany(Section::class, 'imageable');
    }
    /**
     * Get all of the products that are assigned this image.
     */
    public function products() {
        return $this->morphedByMany(Product::class, 'imageable');
    }

}
