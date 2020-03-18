<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Site;
use \App\Product;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //This is landing page!

        //Get product list
        $products = Product::all();
        if($products) {
            $products = $products->toArray();
        }
        return view('index', compact('site','products'));
    }
}
