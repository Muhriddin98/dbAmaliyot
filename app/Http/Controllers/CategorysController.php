<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use Faker\Factory as Faker;
class CategorysController extends BaseController
{
    public function add(){
        $faker = Faker::create();
        for ($i=0; $i<50; $i++){
            $name[$i] = $faker->streetName();
            DB::table('categorys')->insert([
                'name'=>$name[$i]
            ]);
        }
        return response()->json("success", 200);
    }
}
