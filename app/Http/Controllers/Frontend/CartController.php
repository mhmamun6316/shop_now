<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    // add to cart post 

    public function AddToCart(Request $request, $id){

        $product = Product::findOrfail($id);
        // product discount 
        if ($product->discount_price == NULL) {
            Cart::add([
              'id' => $id,
              'name' => $request->product_name,
              'qty' => $request->quantity,               
              'price' => $product->selling_price, 
              'weight' => 1,
              'options' => [
                  'image' => $product->product_thambnail,
                  'color' => $product->color,
                  'size' => $product->size,  
              ],
                ]);
            
            return response()->json(['success' => 'Successfully Added on Your Cart']);

         }else{

            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,               
                'price' => $product->discount_price, 
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thambnail,
                    'color' => $product->color,
                    'size' => $product->size,
                ],
                  ]);

          return response()->json(['success' => 'Successfully Added on Your Cart']);
         }
    } // end mathod 

    // Mini cart Section
    public function AddMiniCart(){
       $carts = Cart::content();
       $cartQty = Cart::count();
       $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => round($cartTotal),
        ));

    } // end mathod 


}
