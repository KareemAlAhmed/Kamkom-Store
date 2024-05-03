<?php

namespace Database\Seeders\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ComputerComponentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = Storage::get('./data/computer-components.json');
        $contents=json_decode($contents);

        foreach($contents as $prod){
            $product=new Product();
            $product->name=$prod->name;
            $product->brand_name=$prod->Vendor;
            $prod->price = str_replace(',', '', $prod->price); 
            $product->price=(float)$prod->price;
            $product->quantity=10;
            $product->thumbnail_url=$prod->thumbnail_url;
            $product->images_url=json_encode($prod->Images_url);
            $user=User::where("FullName",$prod->Vendor)->first();
            $product->user_id=$user->id;
            $subCat=Subcategory::where("name",$prod->ProductType)->first();
            if(isset($subCat)){
                $product->subcategory_id=$subCat->id;
                $product->category_id=$subCat->category_id;
            }else{
                $product->subcategory_id=null;
                $category=Category::where("name",$prod->ProductType)->first();
                $product->category_id=$category->id;
            }
            unset($prod->Images_url);
                        $product->description=$prod->description;
            $product->save();
        }
    }
}
