<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
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

}
