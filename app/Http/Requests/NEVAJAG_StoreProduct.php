<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Product;



class StoreProduct extends FormRequest
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
            'slug' => 'unique:products', //need to add validation
            'category_id' => 'required | numeric',
            'name' => 'required',
            'price' => 'numeric | nullable',
            'description' => 'string | nullable',
            'image' => 'mimes:jpg,jpeg,png | image | nullable'
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
     */
    protected function createSlug() {
        $slug = Str::slug($this->name, '-');
        // Check if slug exists in database
        if(Product::where('slug', $slug)->first()) {
            //Change slug
            $slug = $slug . mt_rand( 0, time() );
        }
        return $slug;
    }
}
