<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;

// Is used to generate PDF
use \Dompdf\Dompdf;

class GrozsController extends Controller
{
    //
    public function index()
    {
        // Get the Product to insert into Cart
        $Product = \App\Product::find(2); // assuming you have a Product model with id, name, description & price

        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();
        
        // \Cart::session($sessionId)->clear(); // Clear the cart

        // Get the Cart contents
        $grozs = \Cart::session($sessionId)->getContent();

        // Get the Cart total price
        $total = \Cart::session($sessionId)->getTotal();
        
        return view('grozs.index', compact('grozs', 'total'));
    }

    public function addToCart(Product $product)
    {   
        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();

        // Should I use Product id?
        // $rowId = 457; // generate a unique() row ID
        // Will use product id while there is no different prices on same product

        // Add Product to Cart
        \Cart::session($sessionId)->add(array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => array('slug' => $product->slug)
        ));        
        return redirect('/darinajumi#'.$product->slug)->with('added', $product->name.' ielikts grozā.');
    }

    public function delete(Product $product) {
        
        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();

        \Cart::session($sessionId)->remove($product->id);

        return back()->with('removed', $product->name.' izņemts no groza!');
    }

    // Cart invoice
    public function invoice() {
        
        return('Rekins');
    }

    // Generate invoice pdf
    public function invoicePdf() {
        // $html = file_get_contents(route('grozs.index'));

        // $dompdf = new Dompdf();
        // $dompdf->loadHTML($html);
        // $dompdf->render();
        // $dompdf->stream();

        return('Rekins Pdf');
    }
}
