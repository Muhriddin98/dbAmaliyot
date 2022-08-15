<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use Faker\Factory as Faker;
class UsersController extends BaseController
{
    public function add(){
        $faker = Faker::create();
        $genders = ['male', 'female'];
        for ($i=0; $i<1000; $i++){
            $gender[$i] = $genders[array_rand($genders)];
            $first_name[$i] = $faker->firstName($gender[$i]);
            $last_name[$i] = $faker->lastName();
            $email[$i] = $faker->email();
            $balance[$i] = rand(10,99)*1000000;
            $birthdate[$i] = $faker->dateTimeBetween('-40 years', '-25 years')->format('Y-m-d');
            DB::table('users')->insert([
                'firstname'=>$first_name[$i],
                'lastname'=>$last_name[$i],
                'birthdate'=>$birthdate[$i],
                'gender'=>$gender[$i],
                'email'=>$email[$i],
                'balance'=>$balance[$i]
            ]);
        }
        return response()->json("success", 200);
    }
}
