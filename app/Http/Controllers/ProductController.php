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

    public function adding_products_json(){
        // $products=[
        //     {"id"=30,"title"="Key Holder","description"="Attractive DesignMetallic materialFour key hooksReliable & DurablePremium Quality",
        //         "price"=30,       //         "rating"=4.92,"stock"=54,"brand"="Golden","category"="home-decoration","thumbnail"="https=//cdn.dummyjson.com/product-images/30/thumbnail.jpg","images"=["https=//cdn.dummyjson.com/product-images/30/1.jpg","https=//cdn.dummyjson.com/product-images/30/2.jpg","https=//cdn.dummyjson.com/product-images/30/3.jpg","https=//cdn.dummyjson.com/product-images/30/thumbnail.jpg"]}
        // ]
        $products=[
            ["id"=>1,"title"=>"iPhone 9","description"=>"An apple mobile which is nothing like apple","price"=>549,"rating"=>4.69,"stock"=>94,"brand"=>"Apple","category"=>"smartphones","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/1/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/1/1.jpg","https=>//cdn.dummyjson.com/product-images/1/2.jpg","https=>//cdn.dummyjson.com/product-images/1/3.jpg","https=>//cdn.dummyjson.com/product-images/1/4.jpg","https=>//cdn.dummyjson.com/product-images/1/thumbnail.jpg"]],
            ["id"=>2,"title"=>"iPhone X","description"=>"SIM-Free, Model A19211 6.5-inch Super Retina HD display with OLED technology A12 Bionic chip with ...","price"=>899,"rating"=>4.44,"stock"=>34,"brand"=>"Apple","category"=>"smartphones","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/2/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/2/1.jpg","https=>//cdn.dummyjson.com/product-images/2/2.jpg","https=>//cdn.dummyjson.com/product-images/2/3.jpg","https=>//cdn.dummyjson.com/product-images/2/thumbnail.jpg"]],
            ["id"=>3,"title"=>"Samsung Universe 9","description"=>"Samsung's new variant which goes beyond Galaxy to the Universe","price"=>1249,"rating"=>4.09,"stock"=>36,"brand"=>"Samsung","category"=>"smartphones","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/3/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/3/1.jpg"]],
            ["id"=>4,"title"=>"OPPOF19","description"=>"OPPO F19 is officially announced on April 2021.","price"=>280,"rating"=>4.3,"stock"=>123,"brand"=>"OPPO","category"=>"smartphones","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/4/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/4/1.jpg","https=>//cdn.dummyjson.com/product-images/4/2.jpg","https=>//cdn.dummyjson.com/product-images/4/3.jpg","https=>//cdn.dummyjson.com/product-images/4/4.jpg","https=>//cdn.dummyjson.com/product-images/4/thumbnail.jpg"]],
            ["id"=>5,"title"=>"Huawei P30","description"=>"Huawei’s re-badged P30 Pro New Edition was officially unveiled yesterday in Germany and now the device has made its way to the UK.","price"=>499,"rating"=>4.09,"stock"=>32,"brand"=>"Huawei","category"=>"smartphones","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/5/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/5/1.jpg","https=>//cdn.dummyjson.com/product-images/5/2.jpg","https=>//cdn.dummyjson.com/product-images/5/3.jpg"]],
            ["id"=>6,"title"=>"MacBook Pro","description"=>"MacBook Pro 2021 with mini-LED display may launch between September, November","price"=>1749,"rating"=>4.57,"stock"=>83,"brand"=>"Apple","category"=>"laptops","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/6/thumbnail.png","images"=>["https=>//cdn.dummyjson.com/product-images/6/1.png","https=>//cdn.dummyjson.com/product-images/6/2.jpg","https=>//cdn.dummyjson.com/product-images/6/3.png","https=>//cdn.dummyjson.com/product-images/6/4.jpg"]],
            ["id"=>7,"title"=>"Samsung Galaxy Book","description"=>"Samsung Galaxy Book S (2020) Laptop With Intel Lakefield Chip, 8GB of RAM Launched","price"=>1499,"rating"=>4.25,"stock"=>50,"brand"=>"Samsung","category"=>"laptops","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/7/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/7/1.jpg","https=>//cdn.dummyjson.com/product-images/7/2.jpg","https=>//cdn.dummyjson.com/product-images/7/3.jpg","https=>//cdn.dummyjson.com/product-images/7/thumbnail.jpg"]],
            ["id"=>8,"title"=>"Microsoft Surface Laptop 4","description"=>"Style and speed. Stand out on HD video calls backed by Studio Mics. Capture ideas on the vibrant touchscreen.","price"=>1499,"rating"=>4.43,"stock"=>68,"brand"=>"Microsoft Surface","category"=>"laptops","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/8/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/8/1.jpg","https=>//cdn.dummyjson.com/product-images/8/2.jpg","https=>//cdn.dummyjson.com/product-images/8/3.jpg","https=>//cdn.dummyjson.com/product-images/8/4.jpg","https=>//cdn.dummyjson.com/product-images/8/thumbnail.jpg"]],
            ["id"=>9,"title"=>"Infinix INBOOK","description"=>"Infinix Inbook X1 Ci3 10th 8GB 256GB 14 Win10 Grey – 1 Year Warranty","price"=>1099,"rating"=>4.54,"stock"=>96,"brand"=>"Infinix","category"=>"laptops","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/9/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/9/1.jpg","https=>//cdn.dummyjson.com/product-images/9/2.png","https=>//cdn.dummyjson.com/product-images/9/3.png","https=>//cdn.dummyjson.com/product-images/9/4.jpg","https=>//cdn.dummyjson.com/product-images/9/thumbnail.jpg"]],
            ["id"=>10,"title"=>"HP Pavilion 15-DK1056WM","description"=>"HP Pavilion 15-DK1056WM Gaming Laptop 10th Gen Core i5, 8GB, 256GB SSD, GTX 1650 4GB, Windows 10","price"=>1099,"rating"=>4.43,"stock"=>89,"brand"=>"HP Pavilion","category"=>"laptops","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/10/thumbnail.jpeg","images"=>["https=>//cdn.dummyjson.com/product-images/10/1.jpg","https=>//cdn.dummyjson.com/product-images/10/2.jpg","https=>//cdn.dummyjson.com/product-images/10/3.jpg","https=>//cdn.dummyjson.com/product-images/10/thumbnail.jpeg"]],
            ["id"=>11,"title"=>"perfume Oil","description"=>"Mega Discount, Impression of Acqua Di Gio by GiorgioArmani concentrated attar perfume Oil","price"=>13,"rating"=>4.26,"stock"=>65,"brand"=>"Impression of Acqua Di Gio","category"=>"fragrances","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/11/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/11/1.jpg","https=>//cdn.dummyjson.com/product-images/11/2.jpg","https=>//cdn.dummyjson.com/product-images/11/3.jpg","https=>//cdn.dummyjson.com/product-images/11/thumbnail.jpg"]],
            ["id"=>12,"title"=>"Brown Perfume","description"=>"Royal_Mirage Sport Brown Perfume for Men & Women - 120ml","price"=>40,"rating"=>4,"stock"=>52,"brand"=>"Royal_Mirage","category"=>"fragrances","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/12/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/12/1.jpg","https=>//cdn.dummyjson.com/product-images/12/2.jpg","https=>//cdn.dummyjson.com/product-images/12/3.png","https=>//cdn.dummyjson.com/product-images/12/4.jpg","https=>//cdn.dummyjson.com/product-images/12/thumbnail.jpg"]],
            ["id"=>13,"title"=>"Fog Scent Xpressio Perfume","description"=>"Product details of Best Fog Scent Xpressio Perfume 100ml For Men cool long lasting perfumes for Men","price"=>13,"rating"=>4.59,"stock"=>61,"brand"=>"Fog Scent Xpressio","category"=>"fragrances","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/13/thumbnail.webp","images"=>["https=>//cdn.dummyjson.com/product-images/13/1.jpg","https=>//cdn.dummyjson.com/product-images/13/2.png","https=>//cdn.dummyjson.com/product-images/13/3.jpg","https=>//cdn.dummyjson.com/product-images/13/4.jpg","https=>//cdn.dummyjson.com/product-images/13/thumbnail.webp"]],
            ["id"=>14,"title"=>"Non-Alcoholic Concentrated Perfume Oil","description"=>"Original Al Munakh® by Mahal Al Musk | Our Impression of Climate | 6ml Non-Alcoholic Concentrated Perfume Oil","price"=>120,"rating"=>4.21,"stock"=>114,"brand"=>"Al Munakh","category"=>"fragrances","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/14/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/14/1.jpg","https=>//cdn.dummyjson.com/product-images/14/2.jpg","https=>//cdn.dummyjson.com/product-images/14/3.jpg","https=>//cdn.dummyjson.com/product-images/14/thumbnail.jpg"]],
            ["id"=>15,"title"=>"Eau De Perfume Spray","description"=>"Genuine  Al-Rehab spray perfume from UAE/Saudi Arabia/Yemen High Quality","price"=>30,"rating"=>4.7,"stock"=>105,"brand"=>"Lord - Al-Rehab","category"=>"fragrances","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/15/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/15/1.jpg","https=>//cdn.dummyjson.com/product-images/15/2.jpg","https=>//cdn.dummyjson.com/product-images/15/3.jpg","https=>//cdn.dummyjson.com/product-images/15/4.jpg","https=>//cdn.dummyjson.com/product-images/15/thumbnail.jpg"]],
            ["id"=>16,"title"=>"Hyaluronic Acid Serum","description"=>"L'OrÃ©al Paris introduces Hyaluron Expert Replumping Serum formulated with 1.5% Hyaluronic Acid","price"=>19,"rating"=>4.83,"stock"=>110,"brand"=>"L'Oreal Paris","category"=>"skincare","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/16/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/16/1.png","https=>//cdn.dummyjson.com/product-images/16/2.webp","https=>//cdn.dummyjson.com/product-images/16/3.jpg","https=>//cdn.dummyjson.com/product-images/16/4.jpg","https=>//cdn.dummyjson.com/product-images/16/thumbnail.jpg"]],
            ["id"=>17,"title"=>"Tree Oil 30ml","description"=>"Tea tree oil contains a number of compounds, including terpinen-4-ol, that have been shown to kill certain bacteria,","price"=>12,"rating"=>4.52,"stock"=>78,"brand"=>"Hemani Tea","category"=>"skincare","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/17/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/17/1.jpg","https=>//cdn.dummyjson.com/product-images/17/2.jpg","https=>//cdn.dummyjson.com/product-images/17/3.jpg","https=>//cdn.dummyjson.com/product-images/17/thumbnail.jpg"]],
            ["id"=>18,"title"=>"Oil Free Moisturizer 100ml","description"=>"Dermive Oil Free Moisturizer with SPF 20 is specifically formulated with ceramides, hyaluronic acid & sunscreen.","price"=>40,"rating"=>4.56,"stock"=>88,"brand"=>"Dermive","category"=>"skincare","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/18/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/18/1.jpg","https=>//cdn.dummyjson.com/product-images/18/2.jpg","https=>//cdn.dummyjson.com/product-images/18/3.jpg","https=>//cdn.dummyjson.com/product-images/18/4.jpg","https=>//cdn.dummyjson.com/product-images/18/thumbnail.jpg"]],
            ["id"=>19,"title"=>"Skin Beauty Serum.","description"=>"Product name=> rorec collagen hyaluronic acid white face serum riceNet weight=> 15 m","price"=>46,"rating"=>4.42,"stock"=>54,"brand"=>"ROREC White Rice","category"=>"skincare","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/19/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/19/1.jpg","https=>//cdn.dummyjson.com/product-images/19/2.jpg","https=>//cdn.dummyjson.com/product-images/19/3.png","https=>//cdn.dummyjson.com/product-images/19/thumbnail.jpg"]],
            ["id"=>20,"title"=>"Freckle Treatment Cream- 15gm","description"=>"Fair & Clear is Pakistan's only pure Freckle cream which helpsfade Freckles, Darkspots and pigments. Mercury level is 0%, so there are no side effects.","price"=>70,"rating"=>4.06,"stock"=>140,"brand"=>"Fair & Clear","category"=>"skincare","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/20/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/20/1.jpg","https=>//cdn.dummyjson.com/product-images/20/2.jpg","https=>//cdn.dummyjson.com/product-images/20/3.jpg","https=>//cdn.dummyjson.com/product-images/20/4.jpg","https=>//cdn.dummyjson.com/product-images/20/thumbnail.jpg"]],
            ["id"=>21,"title"=>"- Daal Masoor 500 grams","description"=>"Fine quality Branded Product Keep in a cool and dry place","price"=>20,"rating"=>4.44,"stock"=>133,"brand"=>"Saaf & Khaas","category"=>"groceries","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/21/thumbnail.png","images"=>["https=>//cdn.dummyjson.com/product-images/21/1.png","https=>//cdn.dummyjson.com/product-images/21/2.jpg","https=>//cdn.dummyjson.com/product-images/21/3.jpg"]],
            ["id"=>22,"title"=>"Elbow Macaroni - 400 gm","description"=>"Product details of Bake Parlor Big Elbow Macaroni - 400 gm","price"=>14,"rating"=>4.57,"stock"=>146,"brand"=>"Bake Parlor Big","category"=>"groceries","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/22/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/22/1.jpg","https=>//cdn.dummyjson.com/product-images/22/2.jpg","https=>//cdn.dummyjson.com/product-images/22/3.jpg"]],
            ["id"=>23,"title"=>"Orange Essence Food Flavou","description"=>"Specifications of Orange Essence Food Flavour For Cakes and Baking Food Item","price"=>14,"rating"=>4.85,"stock"=>26,"brand"=>"Baking Food Items","category"=>"groceries","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/23/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/23/1.jpg","https=>//cdn.dummyjson.com/product-images/23/2.jpg","https=>//cdn.dummyjson.com/product-images/23/3.jpg","https=>//cdn.dummyjson.com/product-images/23/4.jpg","https=>//cdn.dummyjson.com/product-images/23/thumbnail.jpg"]],
            ["id"=>24,"title"=>"cereals muesli fruit nuts","description"=>"original fauji cereal muesli 250gm box pack original fauji cereals muesli fruit nuts flakes breakfast cereal break fast faujicereals cerels cerel foji fouji","price"=>46,"rating"=>4.94,"stock"=>113,"brand"=>"fauji","category"=>"groceries","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/24/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/24/1.jpg","https=>//cdn.dummyjson.com/product-images/24/2.jpg","https=>//cdn.dummyjson.com/product-images/24/3.jpg","https=>//cdn.dummyjson.com/product-images/24/4.jpg","https=>//cdn.dummyjson.com/product-images/24/thumbnail.jpg"]],
            ["id"=>25,"title"=>"Gulab Powder 50 Gram","description"=>"Dry Rose Flower Powder Gulab Powder 50 Gram • Treats Wounds","price"=>70,"rating"=>4.87,"stock"=>47,"brand"=>"Dry Rose","category"=>"groceries","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/25/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/25/1.png","https=>//cdn.dummyjson.com/product-images/25/2.jpg","https=>//cdn.dummyjson.com/product-images/25/3.png","https=>//cdn.dummyjson.com/product-images/25/4.jpg","https=>//cdn.dummyjson.com/product-images/25/thumbnail.jpg"]],
            ["id"=>26,"title"=>"Plant Hanger For Home","description"=>"Boho Decor Plant Hanger For Home Wall Decoration Macrame Wall Hanging Shelf","price"=>41,"rating"=>4.08,"stock"=>131,"brand"=>"Boho Decor","category"=>"home-decoration","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/26/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/26/1.jpg","https=>//cdn.dummyjson.com/product-images/26/2.jpg","https=>//cdn.dummyjson.com/product-images/26/3.jpg","https=>//cdn.dummyjson.com/product-images/26/4.jpg","https=>//cdn.dummyjson.com/product-images/26/5.jpg","https=>//cdn.dummyjson.com/product-images/26/thumbnail.jpg"]],
            ["id"=>27,"title"=>"Flying Wooden Bird","description"=>"Package Include 6 Birds with Adhesive Tape Shape=> 3D Shaped Wooden Birds Material=> Wooden MDF, Laminated 3.5mm","price"=>51,"rating"=>4.41,"stock"=>17,"brand"=>"Flying Wooden","category"=>"home-decoration","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/27/thumbnail.webp","images"=>["https=>//cdn.dummyjson.com/product-images/27/1.jpg","https=>//cdn.dummyjson.com/product-images/27/2.jpg","https=>//cdn.dummyjson.com/product-images/27/3.jpg","https=>//cdn.dummyjson.com/product-images/27/4.jpg","https=>//cdn.dummyjson.com/product-images/27/thumbnail.webp"]],
            ["id"=>28,"title"=>"3D Embellishment Art Lamp","description"=>"3D led lamp sticker Wall sticker 3d wall art light on/off button  cell operated (included)","price"=>20,"rating"=>4.82,"stock"=>54,"brand"=>"LED Lights","category"=>"home-decoration","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/28/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/28/1.jpg","https=>//cdn.dummyjson.com/product-images/28/2.jpg","https=>//cdn.dummyjson.com/product-images/28/3.png","https=>//cdn.dummyjson.com/product-images/28/4.jpg","https=>//cdn.dummyjson.com/product-images/28/thumbnail.jpg"]],
            ["id"=>29,"title"=>"Handcraft Chinese style","description"=>"Handcraft Chinese style art luxury palace hotel villa mansion home decor ceramic vase with brass fruit plate","price"=>60,"rating"=>4.44,"stock"=>7,"brand"=>"luxury palace","category"=>"home-decoration","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/29/thumbnail.webp","images"=>["https=>//cdn.dummyjson.com/product-images/29/1.jpg","https=>//cdn.dummyjson.com/product-images/29/2.jpg","https=>//cdn.dummyjson.com/product-images/29/3.webp","https=>//cdn.dummyjson.com/product-images/29/4.webp","https=>//cdn.dummyjson.com/product-images/29/thumbnail.webp"]],
            ["id"=>30,"title"=>"Key Holder","description"=>"Attractive DesignMetallic materialFour key hooksReliable & DurablePremium Quality","price"=>30,"rating"=>4.92,"stock"=>54,"brand"=>"Golden","category"=>"home-decoration","thumbnail"=>"https=>//cdn.dummyjson.com/product-images/30/thumbnail.jpg","images"=>["https=>//cdn.dummyjson.com/product-images/30/1.jpg","https=>//cdn.dummyjson.com/product-images/30/2.jpg","https=>//cdn.dummyjson.com/product-images/30/3.jpg","https=>//cdn.dummyjson.com/product-images/30/thumbnail.jpg"]]
        ];

    }


}
