<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Product;
use \App\Category;

class DarinajumiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();
        $cart = \Cart::session($sessionId)->getContent()->pluck('id');

        // dd($cart);

        // Get category list
        $categories = Category::orderBy('arrangement', 'asc')->with('products')->get();

        // Map into categories to sanitize Image size collection
        $categories = $categories->map(function($category) use ($cart){ // use -> pass variable inside closure
            $category->products->map(function($product) use ($cart){

                // Lets add attribute inCart if product is in cart 
                if( $cart->contains($product->id) ) {
                    $product['inCart'] = true;
                } else {
                    $product['inCart'] = false;
                }

                // // This is section image
                // $image = $product->image();
                // dd($image);
                //  // If we have image model associated with product
                // if($image) {
                // // Tap into sizes model which is associated with image model
                // // Add imageSize array to $product
                // $product['imageSize'] = $image->sizes->mapWithKeys(function($size){
                //     return [$size->width => $size->url];
                // })->toArray();

                // }
            });
            return $category;
        });

        // Make collection into array
        // $categories = $categories->toArray();
        
        return view('darinajumi.index', compact('categories'));
    }
}
