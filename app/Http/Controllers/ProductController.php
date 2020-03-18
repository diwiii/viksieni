<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // Get validated data array
        $data = $this->validateData();

        // Create slug from name of the resource
        $slug = Str::slug($data['name'], '-');
        if($slug) {
            // Add slug to $data array
            $data['slug'] = $slug;
        }

        // Product please create model from data.
        Product::create($data);

        //Šis nosūtīs uz sākumu
        return redirect(route('root'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
    
    /**
     * Returns validated data
     */

    protected function validateData() 
    {

        $data = request()->validate([
            //'category_id' => 'required | numeric'
            //'featured' => 'numeric | nullable'
            'name' => 'required',
            'price' => 'numeric | nullable',
            'description' => 'string | nullable',
            'image' => 'mimes:jpg,jpeg,png | image | nullable'
        ]);

        if (array_key_exists('image', $data)) {
            return $this->processImage($data);
        }

        return $data;
    }

    /**
     * Returns array with altered 'image' value;
     */

    protected function processImage($data) 
    {
        $imagePath = $data['image']->store('uploads/product', 'public');

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));

        //Limit maximum image width to 768px, also prevent from upsizing
        $image->widen(768, function ($constraint) {
            $constraint->upsize();
        });
        $image->save();

        //Merge the arrays
        $data = array_merge($data, ['image' => $imagePath]);

        return $data;
    }
}

