<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Site;
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
        $category = Category::all()->toArray();
    
        //Get product list
        $products = Product::all()->toArray();
    
        return view('index', compact('products','category'));
    }
}
