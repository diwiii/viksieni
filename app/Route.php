<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = ['url', 'title'];

    public function sections()
    {
        $this->morphedByMany(Section::class, 'routable');
    }
}
