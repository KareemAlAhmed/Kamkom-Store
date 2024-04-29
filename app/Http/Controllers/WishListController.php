<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function create($ownerId){
        $owner=User::find($ownerId);
        if(isset($owner)){
            $list=new WishList();
            $list->owner_id=$ownerId;
            $list->productIds=json_encode([]);
            $list->save();
            return response()->json([
                "status"=>200,
                "success"=>"The WishList Created successfully",
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The User Doesnt Exist."
            ]);
        }
    }

    public function show($listId){
        $wishList=WishList::find($listId);
        if(isset($wishList)){
            $products=[];
            $products_list=json_decode($wishList->productIds);
            foreach($products_list as $id=>$name){
                $products[]=Product::find($id);
            }
            return response()->json([
                "status"=>200,
                "products"=>$products,
            ]);

        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The WishList Doesnt Exist."
            ]);
        }
    }


    public function add_prod($prodId,$listId){
        $wishList=WishList::find($listId);
        $product=Product::find($prodId);

        if(isset($wishList)){

            if(isset($product)){
                $prodList=json_decode($wishList->productIds,true); 
               if(!array_key_exists($prodId, $prodList)){
                    $prodList[$prodId]=$product->name;
                    $wishList->productIds=json_encode($prodList);
                    $wishList->update();
                    return response()->json([
                        "status"=>200,
                        "success"=>"The Product Added Successfully To The Wishlist",
                    ]);
               }else{
                    return response()->json([
                        "status"=>404,
                        "error"=>"The Product Already Exist In Your Wishlist."
                    ]);
               }
 
            }else{
                return response()->json([
                    "status"=>404,
                    "error"=>"The Product Doesnt Exist."
                ]);
            }
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The WishList Doesnt Exist."
            ]);
        }
    }

    public function remove_prod($prodId,$listId){
        $wishList=WishList::find($listId);

        if(isset($wishList)){
            $prodList=json_decode($wishList->productIds);
            if(array_key_exists($prodId, $prodList)){
                foreach($prodList as $key=>$value){
                    if($key == $prodId){
                        unset($prodList->$key);
                    }
                }
                $wishList->productIds=json_encode($prodList);
                $wishList->update();
                return response()->json([
                    "status"=>200,
                    "success"=>"The Product Removed Successfully To The Wishlist",
                ]);
            }else{
                return response()->json([
                    "status"=>404,
                    "error"=>"The Product Doesnt Exist In Your Wishlist."
                ]);
            }          
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The WishList Doesnt Exist."
            ]);
        }
    }


    public function clear($listId){
        $wishList=WishList::find($listId);
        if(isset($wishList)){
 
            $wishList->productIds=json_encode([]);
            $wishList->update();
            return response()->json([
                "status"=>200,
                "success"=>"The Wishlist Cleared Successfuly.",
            ]);

        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The WishList Doesnt Exist."
            ]);
        }
    }
    
}
