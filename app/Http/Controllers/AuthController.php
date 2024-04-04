<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    public function register(Request $request){
        $val=FacadesValidator::make($request->all(),[
            'firstName'=>'required|min:3',
            'secondName'=>'required|min:3',
            'bio'=>'required|min:15',
            'email'=>'required|min:7|email|unique:users',
            "password"=>'required|min:5',
            "mobile_number"=>'required|min:6',
            "country"=>'required|min:3',
            "streetAddress"=>'required|min:18',
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
            $user->firstName=$request['firstName'];
            $user->secondName=$request['secondName'];
            $user->bio=$request['bio'];
            $user->email=$request['email'];
            $user->password=bcrypt($request['password']);
            $user->mobile_number=$request['mobile_number'];
            $user->country=$request['country'];
            $user->streetAddress=$request['streetAddress'];
            $user->province=$request['province'];
            $user->city=$request['city'];
            $user->image_url=$request['image_url'];
            if(isset($user->company_name)){
                $user->company_name=$request['company_name'];
            }
            if(isset($user->company_business)){
                $user->company_business=$request['company_business'];
            }
            $current_time = date("Y-m-d H:i:s");
            $user->email_verified_at=$current_time;
            $id=$user->save();
            $cart=new CartController();
            $cart->create($id);
            $token=$user->createToken('myapptoken')->plainTextToken;
            $data=[$user,$token];

            return response()->json([
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
                'message'=>"You login successfully",
                'user'=>[$user,$token]
            ]);
        }
    }
    public function logout($id){
        $user=User::find($id);
        $user->tokens()->delete();
        return response()->json([
            "message"=>"User logout successfully"
        ]);
    }

    public function show($id){
        $user=User::find($id);

        if($user){
            return response()->json([
                'user'=>$user
            ],200);
        }else{
            return response()->json([
                'error'=>"User Doesnt exist."
            ],404);
        }
    }

    public function sold_items(int $id){
        $user=User::find($id);
        $listIds=$user->sales;
        $items=array();
        foreach($listIds as $item){
            if($item['status'] == "completed"){
                $items[]=Product::find($item['product_id']);
            }
        }
        return response()->json(['items'=>$items]);
    }
    public function purchase_items(int $id){
        $user=User::find($id);
        $listIds=$user->purchases;
        $items=array();
        foreach($listIds as $item){
            if($item['status'] == "completed"){
                $items[]=Product::find($item['product_id']);
            }
        }
        return response()->json(['items'=>$items]);
    }
    public function get_cart($id){
        $user=User::find($id);
        $listIds=$user->purchases;
        $items=array();
        foreach($listIds as $item){
            if($item['status'] == "pending"){
                $items[]=Product::find($item['product_id']);
            }
        }
        return response()->json(['items'=>$items]);
    }
    
    public function get_listed_items($id){
        $user=User::find($id);
        $listIds=$user->sales;
        $items=array();
        foreach($listIds as $item){
            if($item['status'] == "pending"){
                $items[]=Product::find($item['product_id']);
            }
        }
        return response()->json(['items'=>$items]);
    }
    public function change_purchase_info($id,string $ship_to,string $currency){
        $user=User::find($id);
        $user->ship_to=$ship_to;
        $user->currency=$currency;
        $user->update();
        return response()->json([
            "success"=>"Purchase information updated successfully"
        ]);
    }
}
