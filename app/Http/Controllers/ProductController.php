<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    public function create(Request $request,$userId,$catId){
        $val=Validator::make($request->all(),[
            "name"=>"required|min:4|unique:products",
            "brand_name"=>"required|min:4",
            "quantity"=>"required|numeric|gt:0",  
            "price"=>"required|numeric|gt:0",
            "thumbnail_url"=>"required|min:3",
            "images_url"=>"required|min:3"
        ]);
        if($request["spec"]["desc"]){
            $val1=Validator::make($request["spec"],[
                "desc"=>"min:15",
            ]);
            if($val->fails()){
                return response()->json([
                    'status'=>402,
                    'error'=>$val->messages()
                ],402);
            }
        }
        if($val->fails()){
            return response()->json([
                'status'=>402,
                'error'=>$val->messages()
            ],402);
        }else{
            $prod=new Product();
            $prod->name=$request['name'];
            $prod->brand_name=$request['brand_name'];
            $prod->quantity=$request['quantity'];
            $prod->images_url=$request['images_url'];
            $prod->category_id=$catId;
            $prod->user_id=$userId;
            $prod->price=$request['price'];
            $prod->save();
            return response()->json([
                'message'=>"Product created successfully",
                'product'=>$prod,              
            ],200);
        }
    }

    public function show($id){
        $product=Product::find($id);
        if(isset($product)){
            return response()->json([
                'product'=>$product,              
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The Product doesnt exist."
            ],404);
        }
    }
    public function edit(Request $request,$id){
        $prod=Product::find($id);
        if(isset($prod)){
            $val=Validator::make($request->all(),[
                "name"=>"required|min:4|unique:products",
                "description"=>"required|min:15",
                "material"=>"required|min:4",
                "brand_name"=>"required|min:4",
                "quantity"=>"required|numeric|gt:0",
                "color"=>"required|min:3",
                "sold_number"=>"numeric|min:0",
                "weight"=>"required|numeric|gt:0",
                "size"=>"required|min:3|max:10",
                "reviews_number"=>"numeric|min:0",
                "star_number"=>"numeric|min:0",
                "price"=>"required|numeric|gt:0",
                "origin"=>"min:4",
                "images_url"=>"required|min:3"
            ]);
            if($val->fails()){
                return response()->json([
                    'status'=>402,
                    'error'=>$val->messages()
                ],402);
            }else{
                $prod->name=$request['name'];
                $prod->brand_name=$request['brand_name'];
                $prod->quantity=$request['quantity'];
                $prod->specs=$request['specs'];
                $prod->images_url=$request['images_url'];
                $prod->price=$request['price'];
                $prod->update();
                return response()->json([
                    'message'=>"Product updated successfully",
                    'product'=>$prod,              
                ],200);
            }
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The Product doesnt exist."
            ],404);
        }
    }

    public function delete($id){
        $prod=Product::find($id);
        if(isset($prod)){
            $prod->delete();
            return response()->json([
                'message'=>"Product deleted successfully",              
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The Product doesnt exist."
            ],404);
        }
    }

    public function search(Request $request,string $str){
        $max_price=(string)DB::table("products")->max('price');
        
        $raws=DB::table("products");

        if($request["sortFilter"] != ""){
            
                switch($request["sortFilter"]){
                    case "recent":
                        $results=$raws->orderByRaw('created_at DESC')->where([["name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])   
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                      
                        ->orWhere([["description","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        })   
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                        ->get();
                        break;

                    case "priceAcs":
                        $results=$raws->orderByRaw('price ASC')->where([["name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])   
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                    
                        ->orWhere([["description","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        })   
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                        ->get();
                        break;



                    case "priceDesc":
                        $results=$raws->orderByRaw('price DESC')->where([["name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])   
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                    
                        ->orWhere([["description","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        })   
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                        ->get();
                        break;

                    case "bestMatch":
                        $results=$raws->where([["name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])   
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        })                                                           
                        ->get();
                        break;
                    case "popular":
                        $results=$raws->orderByRaw('star_number DESC')->where([["name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])   
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                      
                        ->orWhere([["description","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["category_id"] !="",function($query) use ($request){
                            return $query->where("category_id", $request['category_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        })   
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                        ->get();
                        break;       

                    default:
                        echo "false";
                        break;
                    }



        }else{

        $results=$raws->where([["name","like","%" . $request['name'] . "%"],
        ["price",">=",$request['price1'] ?? '0'],
        ["price","<=",$request['price2'] ?? $max_price]])   
        ->when($request["category_id"] !="",function($query) use ($request){
            return $query->where("category_id", $request['category_id']);
        })
        ->when($request["brand_name"] !="",function($query) use ($request){
            return $query->where("brand_name", $request['brand_name']);
        }) 
        ->when($request["star_number"] !="",function($query) use ($request){
            return $query->where("star_number", ">=","4");
        }) 
        



        ->orWhere([["description","like","%" . $request['name'] . "%"],
        ["price",">=",$request['price1'] ?? '0'],
        ["price","<=",$request['price2'] ?? $max_price]])  
        ->when($request["category_id"] !="",function($query) use ($request){
            return $query->where("category_id", $request['category_id']);
        })
        ->when($request["brand_name"] !="",function($query) use ($request){
            return $query->where("brand_name", $request['brand_name']);
        })   
        ->when($request["star_number"] !="",function($query) use ($request){
            return $query->where("star_number", ">=","4");
        }) 
        ->get();
        }
        return response()->json([
            "results"=>$results,
        ]);
    }
    public function all_prod(){
        $prods=Product::all();
        if(isEmpty($prods)){
            return response()->json([
                "status"=>200,
                "prods"=>$prods
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"There is no Product yet."
            ],404);
        }
    }




}
