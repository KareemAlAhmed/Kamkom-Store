<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CartController extends Controller
{
    public function create($ownerId){
        $owner=User::find($ownerId);
        if($owner){
            $cart=new Cart();
            $cart->owner_id=$ownerId;
            $cart->products_id=json_encode([]);
            $cart->cost=0.00;
            $cart->save();
            return response()->json([
                "status"=>200,
                "success"=>"The Cart Created Successfuly",
                "cart"=>$cart
            ]);
        }else{
            return response()->json([
                "status"=>400,
                "error"=>"The Owner doesnt exist",
            ]);
        }
    }
    public function add($ownerId,$productId){
        $owner=User::find($ownerId);
        $product=Product::find($productId);
        if(!$owner){
            return response()->json([
                "status"=>400,
                "error"=>"The Owner doesnt exist",
            ]);
        }
        if(!$product){
            return response()->json([
                "status"=>404,
                "error"=>"The Product doesnt exist",
            ]);
        }
        $cart=Cart::where("owner_id",$ownerId)->first();
        $prods= json_decode($cart->products_id, true);
        if($product->user_id == $ownerId){
            return response()->json([
                "status"=>404,
                "error"=>"The Buyer Cant Buy his Products",
            ]);
        }
        if(!empty($prods)){
            foreach($prods as $key=>$prod){
                if($key == $productId){
                    $prods[$key]["quantity"]=$prods[$key]["quantity"] + 1;
                }else{
                    $prods[$productId]=["quantity"=>1,"seller"=>User::find($product->user_id)->firstName . " " . User::find($product->user_id)->secondName,"sellerId"=>$product->user_id];
                }
            }
        }else{
            $prods[$productId]=["quantity"=>1,"seller"=>User::find($product->user_id)->firstName . " " . User::find($product->user_id)->secondName,"sellerId"=>$product->user_id];
        }
        $cart->products_id=json_encode($prods);
        $cart->cost=$cart->cost + $product->price;
        $cart->update();
        return response()->json([
            "status"=>200,
            "success"=>"The Product Added to the Cart",
            "cart"=>$cart,
        ]);
    }
    public function show($ownerId){
        $cart=Cart::where("owner_id",$ownerId)->first();
        $prodsJson=json_decode($cart->products_id);
        $prods=[];
        foreach($prodsJson as $prodId=>$value){
            $prod=Product::find($prodId);
            $prods[$value->quantity]=$prod;
        }
        if($cart){
            return response()->json([
                "status"=>200,
                "cart"=>$cart,
                "prods"=>$prods
            ]);
        }else{
            return response()->json([
                "status"=>400,
                "error"=>"The Cart doesnt exist",
            ]);
        }
    }
    public function remove($ownerId,$productId){
        $owner=User::find($ownerId);
        if(!$owner){
            return response()->json([
                "status"=>400,
                "error"=>"The Owner doesnt exist",
            ]);
        }
        $cart=Cart::where("owner_id",$ownerId)->first();
        if(!$cart){
            return response()->json([
                "status"=>400,
                "error"=>"The Cart doesnt exist",
            ]);
        }
        $product=Product::find($productId);
        if(!$product){
            return response()->json([
                "status"=>400,
                "error"=>"The Product doesnt exist",
            ]);
        }
        $prods= json_decode($cart->products_id, true);
        if(!empty($prods)){
            foreach($prods as $prod=>$value){
                if($prod == $productId){
                    $prods[$prod]["quantity"]-=1;
                    if($prods[$prod]["quantity"] == 0){
                        unset($prods[$prod]); 
                    }
                    
                }
            }
        }else{
            return response()->json([
                "status"=>40,
                "error"=>"The Cart is empty"
            ]); 
        }
        $cart->products_id=json_encode($prods);
        $cart->cost =  $cart->cost - $product->price;
        $cart->update();
        return response()->json([
            "status"=>200,
            "success"=>"The Product removed succesfuly",
            "cart"=>$cart,
        ]); 
    }
}
