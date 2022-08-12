<?php

namespace App\Http\Controllers;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class CompanysController extends BaseController
{
    public function add(){
        $faker = Faker::create();
        for ($i=0; $i<100; $i++){
            $name[$i] = $faker->company();
            $balance[$i] = rand(1,99)*1000000;
            DB::table('companys')->insert([
                'name'=>$name[$i],
                'account_balance'=>$balance[$i]
            ]);
        }
        return response()->json("success", 200);
    }
}
