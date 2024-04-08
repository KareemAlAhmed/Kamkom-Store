<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseCompleted;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function create($cartId,$buyerId){

        $buyer=User::find($buyerId);
        $cart=Cart::find($cartId);
        $productsId=json_decode($cart->products_id);
        if(!$buyer){
            return response()->json([
                "status"=>404,
                "error"=>"The Buyer User Doesnt Exist."
            ]);
        }
        if(empty($productsId)){
            return response()->json([
                "status"=>404,
                "error"=>"The Cart is Empty."
            ]);
        }
        $cost=0.00;
        $sellers=[];
        foreach($productsId as $prodId=>$value){
            $prod=Product::find($prodId);
            $cost=$cost + $value->quantity* $prod->price;
            $seller=User::where("id",$value->sellerId)->first();
            $sellers[]=$seller->id;
            
        }
            if(($buyer->balance - $cost) >= 0){
                $prch=new Purchase();
                $prch->buyer_id=$buyerId;
                $prch->seller_id=json_encode($sellers);
                $prch->cart_id=$cartId;
                $prch->cost=$cost;
                $buyer->balance-= $cost;
                // $buyer->update();
                foreach($productsId as $prodId=>$value){
                    $prod=Product::find($prodId);
                    $seller=User::where("id",$value->sellerId)->first();

                    $seller->balance=$seller->balance + ($value->quantity* $prod->price);
                    $prod->quantity=$prod->quantity - $value->quantity;
                    // $seller->update();
                    // $prod->update();
                }
                $cart->products_id=[];
                $cart->cost=0.00;
                // $cart->update();
                $idP= $prch->save();
                Mail::to("karim.abouamer2015@gmail.com")->send(new PurchaseCompleted($productsId,$buyer,$idP,$cost));
                return response()->json([
                    "status"=>200,
                    "success"=>"The Purchase Created successfully",
                    "purchase"=>$prch
                ]);
            }else{
                return response()->json([
                    "status"=>402,
                    "error"=>"Insufficient Funds!"
                ]);  
            }     
    }

    public function show($purchaseId){
        $prch=Purchase::find($purchaseId);
        if($prch){ 
            return response()->json([
                "status"=>200,
                "purchase"=>$prch
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The Purchase Doesnt Exist."
            ]);
        }
    }
    public function edit($purchaseId){
        $prch=Purchase::find($purchaseId);
        if($prch){ 
            return response()->json([
                "status"=>200,
                "purchase"=>$prch
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The Purchase Doesnt Exist."
            ]);
        }
    }

    // public function update(Request $request,$purchaseId){
    //     $prch=Purchase::find($purchaseId);
    //     $buyer=User::find($prch->buyer_id);
    //     $product=Product::find($prch->product_id);
    //     $seller=User::find($prch->seller_id);
    
    //     if(!$prch){
    //         return response()->json([
    //             "status"=>404,
    //             "error"=>"The Purchase Doesnt Exist.",
    //         ]);
    //     }

    //         $cost= $product->price * (int)$request["quantity"];
    //         $diff=$cost - $prch->cost;
    //         if($diff > 0){
    //             if(($buyer->balance - $diff) >=0){
    //                 $prch->cost=$cost;
    //                 $prch->quantity=(int)$request["quantity"];
    //                 $buyer->balance=$buyer->balance - $diff;
    //                 $seller->balance=$seller->balance + $diff;
    //                 $product->quantity=$product->quantity - (int)$request["quantity"];
    //                 $prch->update();
    //                 $product->update();
    //                 $seller->update();
    //                 $buyer->update();
    //                 return response()->json([
    //                     "status"=>200,
    //                     "success"=>"The Purchase updated successfully",
    //                     "purchase"=>$prch
    //                 ]);
    //             }else{
    //                 return response()->json([
    //                     "status"=>402,
    //                     "error"=>"Insufficient Funds!"
    //                 ]);  
    //             }
    //         }else{
    //             $buyer->balance= $buyer->balance + abs($diff);
    //             $seller->balance= $seller->balance - abs($diff);

    //             $prch->quantity=(int)$request["quantity"];
    //             $prch->cost=$cost;
    //             $product->quantity=$product->quantity - (int)$request["quantity"];
    //             $prch->update();
    //             $product->update();
    //             $buyer->update();
    //             $seller->update();
    //                 return response()->json([
    //                     "status"=>200,
    //                     "success"=>"The Purchase updated successfully",
    //                     "purchase"=>$prch
    //                 ]);
    //         }


        
    // }

    public function delete($prchId){
        $prch=Purchase::find($prchId);
        $buyer=User::find($prch->buyer_id);
        $cart=Cart::find($prch->cart_id);
        if($prch){
            $buyer->balance = $buyer->balance + $prch->cost;
            foreach($cart->products_id as $prodId=>$value){
                $prod=Product::find($prodId);
                $seller=User::where("id",$value->sellerId)->first();

                $seller->balance=$seller->balance - ($value->quantity* $prod->price);
                $prod->quantity=$prod->quantity + $value->quantity;
                $seller->update();
                $prod->update();
            }
            $buyer->update();;
            $prch->delete();

            return response()->json([
                "status"=>200,
                "success"=>"The Purchase Deleted successfully",
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The Purchase Doesnt Exist.",
            ]);
        }
    }
}
