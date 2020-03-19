<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = [ 'name', 'arrangement', 'slug' ];

    /**
     * Get the products
     * 
     * //$category->products
     */
    public function products() {
        //vajag pamēģināt arī hasMany(Product::class) 
        return $this->hasMany(Product::class, 'category_id'); // select * from dishes where category_id = 
    }
}
