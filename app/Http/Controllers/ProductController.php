<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\ProductRequest;

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
        $products = Product::all();

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // Product model please create model vai object? from validated data.
        Product::create($this->processRequestData($request));

        //Šis nosūtīs uz izveidoto resursu
        return redirect(route('product.show', $request['slug']));
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
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product )
    {
        // Set $image to null in case if we don't get imageId
        $image = null;

        // If url query contains ?select=image
        if (request('select') === 'image') {
            $images = Image::all();
            
            // Return list of all images with option to select one for the product.
            // We pass Product to View so that we know for which product we choose image.
            return view('image.index', compact('images', 'product'));
        }

        // If url query contains ?imageId=$image->id
        if (request('imageId')) {
            $imageId = request('imageId');
            // Get the image for selected id or fail.
            $image = Image::findOrFail($imageId);
        }
        
        // Get the categories
        $categories = Category::all();
        return view('product.edit', compact('categories', 'product', 'image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request = $this->processRequestData($request);

        // Product please update model validated and processed request data.
        $product->update($request);

        // If we have imageId attach it to section.
        if ( isset($request['imageId']) ) {
            $product->images()->attach($request['imageId']);
        }

        //Returns to edited resource
        return redirect($product->path());
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
        $product->delete();

        return redirect(route('root'));
    }
    
    /**
     * Process validated request data
     * 
     * @return array
     */

    protected function processRequestData($request) 
    {
        $request = $request->validated();
        // Check if image key exists
        // if (array_key_exists('image', $request)) {
        //     $request = $this->processImage($request);
        // }
        return $request;
    }

    
    /**
     * Returns array with altered 'image' value, 
     * Returns array with additional key -> image_id
     * 
     * 
     * @return array
     */
    protected function processImage($data) 
    {
        // Generate image name from slug and date
        // $imageName = $data['slug']."-".date("d-m-y-his");
        

        // Store image as $imageName
        // $imagePath = $data['image']->storeAs('uploads/section', $imageName);


        // Store uploaded image , atm will store in images folder
        $imagePath = $data['image']->store('uploads/images', 'public');

        // Keep in mind that "Image" and "\Image" are two different things

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));

        // Get image name which will be saved in database
        $imageName = $image->basename;
        
        // Create new record
        $imageRow = new Image;
        $imageRow = $imageRow->create(['url'=>$imageName]);
        // Create 2 sizes record;
        $imageRow->sizes()->createMany([

            [
            'width'=>768,
            'url'=>'768/'.$imageName
            ],

            [
            'width'=>480,
            'url'=>'480/'.$imageName
            ]

        ]);

        // Save image name and image_id back to array
        $data = array_merge($data, [
            'image' => $imageName,
            'image_id' => $imageRow->id
        ]);

        //EDIT THE IMAGE SIZES

        //TODO if we dont have folders 768 and 480 please create them, else we get errors.

        // Limit maximum image width to 1024px, also prevent from upsizing
        $image->widen(1024, function ($constraint) {
            $constraint->upsize();
        });
        $image->save();

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));
        //Limit maximum image width to 768px, also prevent from upsizing
        $image->widen(768, function ($constraint) {
            $constraint->upsize();
        });
        $image->save($image->dirname."/768/".$image->basename);
        
        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));
        //Limit maximum image width to 480px, also prevent from upsizing
        $image->widen(480, function ($constraint) {
            $constraint->upsize();
        });
        $image->save($image->dirname."/480/".$image->basename);

        

        return $data;
    }
}
