<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use PHPUnit\Framework\Constraint\IsEmpty;

use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    public function register(Request $request){
        $val=FacadesValidator::make($request->all(),[
            'firstName'=>'required|min:3',
            'secondName'=>'required|min:3',
            'bio'=>'min:15',
            'email'=>'required|min:7|email|unique:users',
            "password"=>'required|min:5',
            "country"=>'required|min:3',
            "streetAddress"=>'required|min:16',
            "province"=>'required|min:4',
            "city"=>'required|min:3',
            "image_url"=>'min:3',
            "company_name"=>'min:4',
            "company_business"=>'min:4',
        ]);

        if($val->fails()){
            return response()->json([
                'status'=>402,
                'error'=>$val->messages()
            ],402);
        }else{
            $user=new User();
            $user->fullName=$request['firstName'] . $request['secondName'];
            if(isset($request['bio'])){
                $user->bio=$request['bio'];
            }else{
                $user->bio="Hey there, fellow KamKom shopper! I'm " . $user->fullName .", and I've got some really cool stuff for you here at KamKom Store.";
            }
            $user->email=$request['email'];
            $user->password=bcrypt($request['password']);
            $user->balance=500.00;
            $user->kamkom_number=rand(10000000, 99999999);
            $user->country=$request['country'];
            $user->streetAddress=$request['streetAddress'];
            $user->province=$request['province'];
            $user->city=$request['city'];
            
            if($request->hasFile('image_url')){
                $user->image_url=$request->image_url->getClientOriginalName();   
                $request->image_url->storeAs('public/UserProfilePic',$user->image_url);
            }

            if(isset($request['company_name'])){
                $user->company_name=$request['company_name'];
            }
            if(isset($request['company_business'])){
                $user->company_business=$request['company_business'];
            }
            $current_time = date("Y-m-d H:i:s");
            $user->email_verified_at=$current_time;
            $id=$user->save();
            $cart=new CartController();
            $cart->create($id);
            $wishlist=new WishListController();
            $wishlist->create($id);
            $token=$user->createToken('myapptoken')->plainTextToken;
            $data=[$user,$token];

            return response()->json([
                'status'=>200,
                'message'=>"User created successfully",
                'user'=>$data,              
            ],200);

        }
    }

    public function login(Request $request){
        $user=User::where('email',$request['email'])->first();

        if(!$user || !Hash::check($request['password'],$user->password)){
            return response()->json([
                'status'=>402,
                'error'=>"Your credentials are incorrect."
            ],402);
        }else{
            $token=$user->createToken('myapptoken')->plainTextToken;

            return response()->json([
                'status'=>200,
                'message'=>"You login successfully",
                'user'=>[$user,$token]
            ],200);
        }
    }
    public function logout($id){
        $user=User::find($id);
        $user->tokens()->delete();
        return response()->json([
            'status'=>200,
            "message"=>"User logout successfully"
        ],200);
    }

    public function user_data($id){
        $user=User::find($id);

        if($user){
            return response()->json([
                'status'=>200,
                'user'=>$user
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"User Doesnt exist."
            ],404);
        }
    }

    public function update_user(Request $request,$id){
        $user=User::find($id);
        if($user){
            $val=FacadesValidator::make($request->all(),[
                'firstName'=>'required|min:3',
                'secondName'=>'required|min:3',
                'bio'=>'min:15',
                'email'=>'required|min:7|email|unique:users',
                "password"=>'required|min:5',
                "country"=>'required|min:3',
                "streetAddress"=>'required|min:16',
                "province"=>'required|min:4',
                "city"=>'required|min:3',
                "image_url"=>'min:3',
                "company_name"=>'min:4',
                "company_business"=>'min:4',
            ]);
    
            if($val->fails()){
                return response()->json([
                    'status'=>402,
                    'error'=>$val->messages()
                ],402);
            }else{
                $user->fullName=$request['firstName'] . $request['secondName'];
                if(isset($request['bio'])){
                    $user->bio=$request['bio'];
                }else{
                    $user->bio="Hey there, fellow KamKom shopper! I'm " . $user->fullName .", and I've got some really cool stuff for you here at KamKom Store.";
                }
                $user->email=$request['email'];
                $user->password=bcrypt($request['password']);
                $user->country=$request['country'];
                $user->streetAddress=$request['streetAddress'];
                $user->province=$request['province'];
                $user->city=$request['city'];
                
                if($request->hasFile('image_url')){
                    $user->image_url=$request->image_url->getClientOriginalName();   
                    $request->image_url->storeAs('public/UserProfilePic',$user->image_url);
                }
    
                if(isset($request['company_name'])){
                    $user->company_name=$request['company_name'];
                }
                if(isset($request['company_business'])){
                    $user->company_business=$request['company_business'];
                }
                $id=$user->update();
               
    
                return response()->json([
                    'status'=>200,              
                    'message'=>"User Data Updated successfully",
                ],200);
    
            }
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The User Doesnt Exist."
            ],404);
        }
    }

    public function delete_user($id){
        $user=User::find($id);
        if($user){
            $user->delete();
            return response()->json([
                "status"=>200,
                "message"=>"The User Deleted Successfuly."
            ,200]);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The User Doesnt Exist."
            ],404);
        }
    }


    public function sold_items(int $id){
        $user=User::find($id);
        if($user){
            $listIds=$user->sales;
            $items=array();
            foreach($listIds as $item){
                if($item['status'] == "completed"){
                    $items[]=Product::find($item['product_id']);
                }
            }
            return response()->json([
                'status'=>200,
                'items'=>$items
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The User Doesnt Exist."
            ],404);
        }
    }
    public function purchase_items(int $id){
        $user=User::find($id);
        if($user){
            $purchases=$user->purchases;
            $items=array();
            foreach($purchases as $purch){
                $listProd=json_decode($purch->products);
                
                foreach($listProd as $id=>$value){
                    $items[]=["productDetail"=>Product::find($id),"quantity"=>$value->quantity];       
                }
                
            }
            return response()->json([
                'status'=>200,
                'items'=>$items],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The User Doesnt Exist."
            ],404);
        }
    }
    
    public function get_listed_items($id){
        $user=User::find($id);
        if($user){
            $items=$user->products;
            
            return response()->json([
                "status"=>200,
                'items'=>$items],200);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The User Doesnt Exist."
            ],404);
        }
    }
 
    function all(){
        $users=User::all();
        if(!isEmpty($users)){
            return response()->json([
                "status"=>200,
                "users"=>$users
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"There is no Users yet."
            ],404);
        }
    }
    function makeAdmin($userId){
        $user=User::find($userId);
        if($user){
            $user->isAdmin=true;
            $user->update();
            return response()->json([
                "status"=>200,
                "message"=>"The User " . $user->fullName ." Is Admin Now"
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>"The User Doesnt Exist."
            ],404);
        }
    }
}
