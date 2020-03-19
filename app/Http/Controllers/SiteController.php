<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Product;
use \App\Category;

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
            foreach ($categories as $category) {
                $category->products;
            }
        $categories = $categories->toArray();
        
        // $category = Category::all()->toArray();
    
        //Get product list
        $products = Product::all()->toArray();
    
        return view('index', compact('products','categories'));
    }
}
