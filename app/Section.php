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
    protected $fillable = [ 'slug', 'name', 'arrangement', 'image', 'description', 'accent_color', 'content' ];

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

    /**
     * Return array of single image different size paths
     */
    public function getImage() {
        
        $imagePath[0] = "/storage/uploads/section/".$this->image;
        $imagePath[768] = "/storage/uploads/section/768/".$this->image;
        $imagePath[480] = "/storage/uploads/section/480/".$this->image;
        return $imagePath;
    }
}
