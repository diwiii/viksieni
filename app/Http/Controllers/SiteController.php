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
    
        //We do this so the products are accessible in $categories array
        // THERE IS BETTER WAY -> eager loading 
        foreach ($categories as $category) {
            $category->products;
        }
        // Set categories collection to Array
        $categories = $categories->toArray();

        // Get Sections from database with image table
        $sections = Section::with(['image', 'routes'])->get();

        // Map into sections to sanitize Image size collection
        $sections = $sections->map(function($section){
            
            // This is section image
            $image = $section->image;
            // If we have image model associated with section
            if($image) {
                // Tap into sizes model which is associated with image model
                // Add imageSize array to $section
                $section['imageSize'] = $image->sizes->mapWithKeys(function($size){
                    return [$size->width => $size->url];
                });
            }

            // This is section routes
            $routes = $section->routes;
            // If we have routes model associated with section
            if($routes) {
                // Fetch $route->url and put it into array
                $section['urls'] = $routes->map(function($route){
                    return ['url'=>$route->url, 'title'=>$route->title];
                })->toArray();
            }

            return $section;
        });

        // Set sections collection to array
        $sections = $sections->toArray();
        // dd($sections);
        //Get product list
        // $products = Product::all()->toArray();

        return view('index', compact('categories', 'sections'));
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
        $imagePath = $data['logo_img']->store('uploads/site', 'public');

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
