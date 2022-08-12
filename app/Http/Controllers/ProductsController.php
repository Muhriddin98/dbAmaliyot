<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProductsController extends BaseController
{
    public function add(){
        $faker = Faker::create();
        for ($i=0; $i<1000; $i++){
            $category_id[$i] = rand(1,30);
            $company_id[$i] = rand(1,100);
            $name[$i] = $faker->word()." ".$faker->colorName();
            $price[$i] = rand(50,999)*1000;
            $total_amount[$i] = rand(1,99)*100;
            DB::table('products')->insert([
                'category_id'=>$category_id[$i],
                'company_id'=>$company_id[$i],
                'name'=>$name[$i],
                'price'=>$price[$i],
                'total_amount'=>$total_amount[$i]
            ]);
        }
        return response()->json("success", 200);
    }
}
