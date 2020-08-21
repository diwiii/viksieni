<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The relationships that should always be loaded.
     * 
     * This points to sizes() method
     *
     * @var array
     */
    // protected $with = ['image'];

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = [ 'category_id', 'slug', 'name', 'price', 'image_id', 'description', 'volume'];

    /**
     * Get the category
     * 
     * //$product->category
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

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
        return route('product.show', $this);
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
     * Get all of the images for the product.
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
