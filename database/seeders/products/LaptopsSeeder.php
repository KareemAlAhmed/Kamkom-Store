<?php

namespace Database\Seeders\Products;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LaptopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = Storage::get('./data/networking.json');
        $data=[];
        $exist=[];
        $contents=json_decode($contents);
        
        // foreach($contents as $prod){
        //     $specs=json_decode($prod['specs']);
        //     $product=new Product();
        //     $product->name=$prod['name'];
        //     $product->brand_name=$specs['Vendor'];
        //     $product->price=$prod['price'];
        //     $product->quantity=10;
        //     $product->images_url=$specs['Images_url'];
        //     $product->thumbnail_url=$prod['thumbnail_url'];
        //     unset($specs['Images_url']);
        //     unset($specs['Vendor']);
        //     $product->specs=$specs;
        // }
        foreach($contents as $prod){
            // $specs=json_decode($prod->specs);
            $product=new Product();
            $product->name=$prod->name;
            $product->brand_name=$prod->specs->ProductType;
            // $product->price=$prod['price'];
            // $product->quantity=10;
            // $product->images_url=$specs['Images_url'];
            // $product->thumbnail_url=$prod['thumbnail_url'];
            // unset($specs['Images_url']);
            // unset($specs['Vendor']);
            // $product->specs=$specs;
            if (!in_array($product->brand_name, $exist)) {
                array_push($exist,$product->brand_name);
                $data["Fashion"][]=$product->brand_name;
            } 
        }
        print_r($data);
        $file = fopen("example.json", "w");
        $dat=json_encode($data);
        fwrite($file, $dat);
        fclose($file);
    }
}
