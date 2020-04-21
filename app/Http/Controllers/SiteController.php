<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Product;
use \App\Category;
use \App\Section;
use \App\Site;

use \App\Http\Requests\SiteRequest;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //This is landing page! or is this?

        // Get category list
        $categories = Category::orderBy('arrangement', 'asc')->get();
        // $categories = Category::whereIn('id', [1,5])->get()->toArray();
        // Get sections list
    
        //We do this so the products are accessible in $categories array
        foreach ($categories as $category) {
            $category->products;
        }

        $sections = Section::all()->toArray();
        $categories = $categories->toArray();

        // Create sections array from $categories and $sections
        // $sections = array_merge($categories, $sections);


        // dd($sections);
        // dd($categories->only([1,5]));
            
        //dd($categories);
        // $category = Category::all()->toArray();
    
        //Get product list
        $products = Product::all()->toArray();
        return view('index', compact('products','categories', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
        $site = $site->toArray();
        return view('site.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(SiteRequest $request, Site $site)
    {
        // Site please update model from validated and processed request data.
        $site->update($this->processRequestData($request));

        //Returns to edited resource
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
        if (array_key_exists('logo_img', $request) && $request['logo_img'] != null) {
            $request = $this->processImage($request);
        }
        return $request;
    }

    /**
     * Returns array with altered 'image' value;
     * 
     * @return array
     */
    protected function processImage($data) 
    {
        // Store the image
        $imagePath = $data['logo_img']->store('uploads/category', 'public');

        // If the img is svg skip ImageIntervention
        if ($data['logo_img']->getMimeType() === 'image/svg') {
            //Merge the arrays
            $data = array_merge($data, ['logo_img' => $imagePath]);
            
            return $data;
        }

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));

        //Limit maximum image width to 768px, also prevent from upsizing
        $image->widen(768, function ($constraint) {
            $constraint->upsize();
        });
        $image->save();

        //Merge the arrays
        $data = array_merge($data, ['logo_img' => $imagePath]);

        return $data;
    }

}
