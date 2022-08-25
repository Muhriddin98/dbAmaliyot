<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
class ExtjsController extends BaseController
{
    public function add(Request $request){
        $firstname = $request->get('firstName');
        $lastname = $request->get('lastName');
        $birthdate = $request->get('birthDate');
        $address = $request->get('address');
        $city = $request->get('city');
        $state = $request->get('state');
        $values = [
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'birthdate'=>$birthdate,
            'address'=>$address,
            'city'=>$city,
            'state'=>$state
        ];
        $id = DB::table('students')
            ->insertGetId($values);
        if ($id != null){
            return response()->json($id);
        }else{
            return response()->json('xato', 403);
        }

    }
}
