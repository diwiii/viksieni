<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // Category model please create model vai object? from validated data.
        Category::create($this->processRequestData($request));

        return redirect(route('root'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        $category = $category->toArray();
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        $category = $category->toArray();
        $categories = Category::all();
        return view('category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // Category please update model from validated and processed request data.
        $category->update($this->processRequestData($request));

        //Returns to edited resource
        return redirect($category->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
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
        if (array_key_exists('image', $request) && $request['image'] != null) {
            $request = $this->processImage($request);
        }
        return $request;
    }

    //     /**
    //  * Returns validated data
    //  */

    // protected function validateData() 
    // {

    //     $data = request()->validate([
    //         // 'category_id' => 'required | numeric'
    //         // 'featured' => 'numeric | nullable'
    //         // 'price' => 'numeric | nullable'
    //         // 'description' => 'string | nullable'
    //         // 'image' => 'mimes:jpg,jpeg,png | image | nullable
    //         'name' => 'required',
    //         'arrangement' => 'nullable | numeric',
    //         'description' => 'nullable | string',
    //         'image' => 'nullable | image | mimes:jpg,jpeg,png'
    //     ]);

    //     if (array_key_exists('image', $data)) {
    //         $data = $this->processImage($data);
    //     }

    //     return $data;
    // }

    /**
     * Returns array with altered 'image' value;
     * 
     * @return array
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
