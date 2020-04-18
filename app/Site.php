<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = [ 'name', 'description', 'info_phone', 'info_email', 'info_location', 'info_details', 'logo_img', 'img_description' ];
}
