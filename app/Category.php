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
    protected $fillable = [ 'slug', 'name', 'arrangement', 'image', 'description' ];

    /**
     * Get the products
     * 
     * //$category->products
     */
    public function products() {
        //vajag pamēģināt arī hasMany(Product::class) 
        return $this->hasMany(Product::class, 'category_id'); // select * from dishes where category_id = 
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
        return route('category.show', $this);
    }
}
