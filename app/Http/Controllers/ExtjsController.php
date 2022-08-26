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
            DB::table('students')
                ->where('id','=',$id)
                ->get();
            $response = [
                "success"=>true,
                "reason"=>"Success"
            ];
            return response()->json($response,200);
        }else{
            $response = [
                "success"=>false,
                "reason"=>"Error"
            ];
            return response()->json($response, 403);
        }
    }
    public function show(){
        $data = DB::table('students')->get();
        return response()->json($data);
    }
    public function update(Request $request, $id){
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $birthdate = $request->get('birthdate');
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
        if ($id != null){
            DB::table('students')
                ->where('id','=',$id)
                ->update($values);
            $response = [
                "success"=>true,
                "reason"=>"Success"
            ];
            return response()->json($response,200);
        }else{
            $response = [
                "success"=>false,
                "reason"=>"Error"
            ];
            return response()->json($response, 403);
        }
    }
    public function delete(Request $request){
        $id = $request->get('id');
        if ($id > 0){
            DB::table('students')
                ->delete($id);
            $response = [
                "success"=>true,
                "reason"=>"Success"
            ];
            return response()->json($response,200);
        }else{
            $response = [
                "success"=>false,
                "reason"=>"Error"
            ];
            return response()->json($response, 404);
        }
    }
}
