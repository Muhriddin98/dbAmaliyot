<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
class OrdersController extends BaseController
{
    public function add(){
        for ($i=0; $i<1000; $i++){
            $user_id = rand(1,1000);
            $order_status = 'process';
            $order_id = DB::table('orders')
                ->insertGetId([
                'user_id'=>$user_id,
                'status'=>$order_status
            ]);
            $summa = 0;
            $random = rand(1, 5);
            for ($j=0; $j<$random; $j++){
                $product_id = rand(1,1000);
                $product_quantity = rand(1,5);
                $product_price = DB::table('products')
                    ->where('Id','=',$product_id)
                    ->value('price');
                DB::table('order_items')
                    ->insert([
                    'product_id'=>$product_id,
                    'product_quantity'=>$product_quantity,
                    'product_price'=>$product_price,
                    'order_id'=>$order_id
                ]);
                $product_amount = DB::table('product')
                    ->where('Id','=', $product_id)
                    ->value('total_amount');
                if ($product_amount < $product_quantity){
                    $order_status = 'failed';
                    DB::table('order')
                        ->where('Id','=', $order_id)
                        ->update([
                            'status'=>$order_status
                        ]);
                }
                $summa = $summa + ($product_quantity * $product_price);
            }
            $user_balance = DB::table('users')
                ->where('Id', '=', $user_id)
                ->value('balance');
            if ($order_status == 'failed'){
                $tran_status = 'abort';
            }elseif ($user_balance < $summa){
                $tran_status = 'failed';
            }else{
                $order_status = 'success';
                $tran_status = 'success';
                DB::table('order')
                    ->where('Id','=', $order_id)
                    ->update([
                        'status'=>$order_status
                    ]);
            }
            DB::table('transaction')
                ->insert([
                    'order_id'=>$order_id,
                    'user_id'=>$user_id,
                    'summa'=>$summa,
                    'status'=>$tran_status,
                ]);
        }
    }
}
