<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use App\Models\Product;
use App\Models\Wishlist;
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
                  'color' => $product->product_color,
                  'size' => $product->product_size,  
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
                    'color' => $product->product_color,
                    'size' => $product->product_size,
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
            'cartTotal' => $cartTotal,
        ));

    } // end mathod 

    /// remove mini cart 
    public function RemoveMiniCart($rowId){ 
        Cart::remove($rowId);
        return response()->json(['success' => 'Product Remove from Cart']);

    } // end mehtod 

     // add to wishlist Product mathod 
     public function AddToWishlist(Request $request, $product_id){
        if (Auth::check()){
            $exists = Wishlist::where('user_id',Auth::id())->where('product_id',$product_id)->first();
            if (!$exists) {       
            Wishlist::insert([
                'user_id' => Auth::id(), 
                'product_id' => $product_id, 
                'created_at' => Carbon::now(), 
            ]);
            
           return response()->json(['success' => 'Successfully Added On Your Wishlist']);
            }else{
                return response()->json(['error' => 'Product Already Wishlist Add ']); 
            }
        }else{
            return response()->json(['error' => 'At First Login Your Account']);
        }
   

    } // end method 


}
