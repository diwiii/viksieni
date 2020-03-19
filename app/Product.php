<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = [ 'category_id', 'slug', 'name', 'price', 'image', 'description' ];

    /**
     * Get the category
     * 
     * //$product->category
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
