<?php

namespace App\Http\Requests;

use App\Section;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SectionRequest extends FormRequest
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
            'slug' => Rule::unique('products')->ignore($this->id), // Šis ir nepareizs
            'name' => 'required',
            'arrangement' => 'nullable | numeric',
            'description' => 'nullable | string',
            'content' => 'nullable | string',
            'accent_color' => 'nullable | string',
            'imageId' => 'nullable | integer'
        ];
    }

    
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {   
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
        $section = Section::where('slug', $slug)->first();
        // If slug exists
        if($section) {
            // And request id is not equal to section id
            if ($section->id != $this->id ) {
                //Change slug
                $slug = $slug . mt_rand( 0, time() );
            }
        }

        return $slug;
    }
}