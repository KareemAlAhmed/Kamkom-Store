<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function create(Request $request,$reviewerId,$prodId){
        $val=Validator::make($request->all(),[
            "content"=>"required|min:3",
            "star_numbers"=>"required|lte:5"
        ]);
        if(!User::find($reviewerId)){
            return response()->json([
                "status"=>404,
                "error"=>"The Reviewer User Doesnt Exist."
            ]);
        }
        if(!Product::find($prodId)){
            return response()->json([
                "status"=>404,
                "error"=>"The Product Doesnt Exist."
            ]);
        }
        if($val->fails()){
            return response()->json([
                "status"=>402,
                "error"=>$val->messages()
            ]);
        }else{
            $rev=new Review();
            $rev->content=$request["content"];
            $rev->star_numbers=$request["star_numbers"];
            $rev->reviewer_id=$reviewerId;
            $rev->product_id=$prodId;
            $rev->save();

            return response()->json([
                "status"=>200,
                "success"=>"The Review Created successfully",
                "rev"=>$rev
            ]);
        }
    }

    public function show($reviewId){
        $rev=Review::find($reviewId);
        if($rev){ 
            return response()->json([
                "status"=>200,
                "rev"=>$rev
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The Review Doesnt Exist."
            ]);
        }
    }
    public function edit($reviewId){
        $rev=Review::find($reviewId);
        if($rev){ 
            return response()->json([
                "status"=>200,
                "rev"=>$rev
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The Review Doesnt Exist."
            ]);
        }
    }

    public function update(Request $request,$reviewId){
        $rev=Review::find($reviewId);

        $val=Validator::make($request->all(),[
            "content"=>"required|min:3",
            "star_numbers"=>"required|lte:5"
        ]);
        if(!$rev){
            return response()->json([
                "status"=>402,
                "error"=>"The Review Doesnt Exist.",
            ]);
        }
        if($val->fails()){
            return response()->json([
                "status"=>402,
                "error"=>$val->messages()
            ]);
        }else{
            $rev->content=$request["content"];
            $rev->star_numbers=$request["star_numbers"];
            $rev->update();

            return response()->json([
                "status"=>200,
                "success"=>"The Review updated successfully",
                "rev"=>$rev
            ]);
        }
    }
}
