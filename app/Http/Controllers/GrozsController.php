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
        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();
        
        // \Cart::session($sessionId)->clear(); // Clear the cart

        // Get the Cart contents
        // Use sort otherwise when quantity is increased arrangement on cart table changes
        $grozs = \Cart::session($sessionId)->getContent()->sortBy('name');

        // dd($grozs);
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
                'attributes' => array(
                    'slug' => $product->slug,
                    'volume' => $product->volume
                    )
        ));        
        return redirect('/darinajumi#'.$product->slug)->with('added', $product->name.' ielikts grozā.');
    }

    /**
     *  Update the cart item
     */
    public function update(Product $product) {
        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();

        \Cart::session($sessionId);

        // Get the quantity
        $quantity = (\Cart::get($product->id)->quantity);
        $do = request()->input('do');

        if($do === 'decrease' && $quantity === 1) {
            return back()->with('status', 'Nevar samazināt, spied izņemt no groza.');
        } elseif($do === 'decrease') {
            \Cart::update($product->id, array(
               'quantity' => -1 
            ));
            return back();
        }
        if($do === 'increase') {
            \Cart::update($product->id, array(
                'quantity' => +1 
            ));
            return back();
        }
    }

    public function delete(Product $product) {
        
        // Get session key to use as unique identifier
        $sessionId = request()->session()->getId();

        \Cart::session($sessionId)->remove($product->id);

        // If we are in darinajumi send back to product slug
        if(url()->previous() === route('darinajumi.index')){
            
            // Combine darinajumi with product slug into url
            $url = route('darinajumi.index').'#'.$product->slug;

            return redirect($url)->with('removed', $product->name.' izņemts no groza!');
        }

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
