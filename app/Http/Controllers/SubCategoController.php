<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubCategoController extends Controller
{
    public function create(Request $request){
        $val=Validator::make($request->all(),[
            "name"=>"required|min:4|unique:categories",
        ]);
        if($val->fails()){
            return response()->json([
                'status'=>402,
                'error'=>$val->messages()
            ],402);
        }else{
            $category=new Category();
            $category->name=$request['name'];
            $category->save();
            return response()->json([
                'message'=>"Category created successfully",
                'category'=>$category,              
            ],200);
        }
    }

    public function show($id){
        $category=Category::find($id);
        if(isset($category)){
            return response()->json([
                'category'=>$category,              
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The category doesnt exist."
            ],404);
        }
    }
    public function edit(Request $request,$id){
        $category=Category::find($id);
        if(isset($category)){
            $val=Validator::make($request->all(),[
                "name"=>"required|min:4|unique:categories",
            ]);
            if($val->fails()){
                return response()->json([
                    'status'=>402,
                    'error'=>$val->messages()
                ],402);
            }else{
                $category->name=$request['name'];
                $category->update();
                return response()->json([
                    'message'=>"category updated successfully",
                    'category'=>$category,              
                ],200);
            }
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The category doesnt exist."
            ],404);
        }
    }

    public function delete($id){
        $category=Category::find($id);
        if(isset($category)){
            $category->delete();
            return response()->json([
                'message'=>"category deleted successfully",              
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The category doesnt exist."
            ],404);
        }
    }
    public function search(string $catName,string $prodName){
        $cat=Category::where("name",$catName)->first();
        $raws=DB::table("products")
            ->where([["category_id","=",$cat->id],["name","like","%" . $prodName . "%"]])
            ->orWhere([["category_id","=",$cat->id],["description","like","%" . $prodName . "%"]])
            ->get();
        return response()->json([
            "results"=>$raws
        ]);
    }
    function all(){
        $subcategories=Subcategory::all();
        return response()->json([
            "status"=>200,
            "subcategories"=>$subcategories
        ]);
    }
}
