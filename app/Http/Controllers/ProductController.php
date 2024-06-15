<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    public function create(Request $request,$userId){
        $val=Validator::make($request->all(),[
            "name"=>"required|min:4|unique:products",
            "brand"=>"required|min:4",
            "description"=>"required|min:10",
            "price"=>"required|numeric|gt:0",
            "quantity"=>"required|numeric|gt:0",  
            // "thumbnail_url"=>"required|min:3",
            "category"=>"required|min:3",
            // "subcategory_id"=>"required|ge:0" 
        ]);
        $images=json_decode($request["images_url"]);
        $images_urls=[];
        foreach($images as $key=>$img){
            array_push($images_urls,$img->path);
        }

        if(!isset($images_urls)){
            return response()->json([
                'status'=>402,
                'error'=>"There should be at least one image."
            ],402);
        }else{
            foreach($images_urls as $img){
                $val2=Validator::make($images_urls,[
                    "min:4"
                ]);
                if($val2->fails()){
                    return response()->json([
                        'status'=>402,
                        'error'=>$val->messages()
                    ],402);
                }
            }
        }

        if($val->fails()){
            return response()->json([
                'status'=>402,
                'error'=>$val->messages()
            ],402);
        }else{
            $cat=Category::where("name",$request['category'])->first();
            if(isset($cat)){
                $prod=new Product();
                $prod->name=$request['name'];
                $prod->brand_name=$request['brand'];
                $prod->price=$request['price'];
                $prod->quantity=$request['quantity'];
                $prod->images_url=json_encode($images_urls);
                $prod->thumbnail_url=$images_urls[0];
                $prod->description=$request['description'];
                
                $prod->category_id=$cat->id;
                // $prod->subcategory_id=(int)$request['subcategory_id'];
                $prod->user_id=$userId;
                $prod->save();
                return response()->json([
                    'message'=>"Product created successfully",
                    'product'=>$prod,              
                ],200);
            }else{
                return response()->json([
                    'status'=>404,
                    'error'=>"The Category or SubCategory doesnt exist."
                ],404);
            }
        }
    }

    public function show($id){
        $product=Product::find($id);
        if(isset($product)){
            return response()->json([
                'status'=>200,
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
                "brand"=>"required|min:4",
                "quantity"=>"required|numeric|gt:0",  
                "price"=>"required|numeric|gt:0",
                "thumbnail_url"=>"required|min:3",
                "description"=>"required|min:10",
            ]);
            if($val->fails()){
                return response()->json([
                    'status'=>402,
                    'error'=>$val->messages()
                ],402);
            }else{
                $prod->name=$request['name'];
                $prod->brand=$request['brand'];
                $prod->price=$request['price'];
                $prod->quantity=$request['quantity'];
                $prod->description=$request['description'];
                $prod->images_url=json_encode($request['images_url']);
                $prod->thumbnail_url=$request['thumbnail_url'];
                $prod->category_id=(int)$request['category_id'];
                $prod->subcategory_id=(int)$request['subcategory_id'];
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
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                      
                        ->orWhere([["brand_name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
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
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                    
                        ->orWhere([["brand_name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
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
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                    
                        ->orWhere([["brand_name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
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
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
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
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
                        })
                        ->when($request["brand_name"] !="",function($query) use ($request){
                            return $query->where("brand_name", $request['brand_name']);
                        }) 
                        ->when($request["star_number"] !="",function($query) use ($request){
                            return $query->where("star_number", ">=","4");
                        }) 
                                      
                        ->orWhere([["brand_name","like","%" . $request['name'] . "%"],
                        ["price",">=",$request['price1'] ?? '0'],
                        ["price","<=",$request['price2'] ?? $max_price]])  
                        ->when($request["subcategory_id"] !="",function($query) use ($request){
                            return $query->where("subcategory_id", $request['subcategory_id']);
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
        ->when($request["subcategory_id"] !="",function($query) use ($request){
            return $query->where("subcategory_id", $request['subcategory_id']);
        })
        ->when($request["brand_name"] !="",function($query) use ($request){
            return $query->where("brand_name", $request['brand_name']);
        }) 
        ->when($request["star_number"] !="",function($query) use ($request){
            return $query->where("star_number", ">=","4");
        }) 
        



        ->orWhere([["brand_name","like","%" . $request['name'] . "%"],
        ["price",">=",$request['price1'] ?? '0'],
        ["price","<=",$request['price2'] ?? $max_price]])  
        ->when($request["subcategory_id"] !="",function($query) use ($request){
            return $query->where("subcategory_id", $request['subcategory_id']);
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

    public function test(Request $request){
        if($request->hasFile('file')){      
            $request->file->storeAs('public/UserProfilePic', $request->file->getClientOriginalName());
        }
        return true;
    }
    public function searchByCate(string $catName){
        $cat=Category::where('name',$catName)->first();
        if(isset($cat)){
            return response()->json([
                "status"=>200,
                "prods"=>Product::where('category_id',$cat->id)->get()
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "error"=>"The Wanted Category Doesnt Exist!"
            ]);
        }
    }

}
