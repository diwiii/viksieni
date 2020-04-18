<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required',
            'description' => 'nullable | string',
            'info_phone' => 'nullable | string',
            'info_email' => 'nullable | email',
            'info_location' => 'nullable | string',
            'info_details' => 'nullable | string',
            'logo_img' => 'nullable | mimes:jpg,jpeg,png,svg,html | image', //svg, html is needed for svg file to pass
            'img_description' => 'nullable | string'
        ];
    }

    
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {   
        // if($this->file('logo_img')->getMimeType() === 'image/svg') {
        //     dd('boo');
        // }
        $this->merge([
            'slug' => $this->createSlug(),
        ]);
    }

    /**
     * Create slug from name and check if it exists in database
     * 
     * @return variable slug
     */
    protected function createSlug() {
        //Ja ir produkta id un slug nav null
        if ( $this->id && $this->slug != null) {
            // Tad izmantojam pieprasījuma slug
            $slug = $this->slug;
        } else {
            // Ja nav produkta id
            // Izveidojam slugu no pieprasījuma vārda
            $slug = Str::slug($this->name, '-');
        }
        // Check if slug exists in database and assign to variable
        $category = Category::where('slug', $slug)->first();
        // If slug exists
        if($category) {
            // And request id is not equal to category id
            if ($category->id != $this->id ) {
                //Change slug
                $slug = $slug . mt_rand( 0, time() );
            }
        }

        return $slug;
    }
}
