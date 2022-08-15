<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
class OrdersController extends BaseController
{
    public function add(){
        set_time_limit(1000);
        for ($i=0; $i<10000; $i++){
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
                    ->where('id','=',$product_id)
                    ->value('price');
                DB::table('order_items')
                    ->insert([
                    'product_id'        => $product_id,
                    'product_quantity'  => $product_quantity,
                    'product_price'     => $product_price,
                    'order_id'          => $order_id
                ]);
                $product_amount = DB::table('products')
                    ->where('id','=', $product_id)
                    ->value('total_amount');
                if ($product_amount < $product_quantity){
                    $order_status = 'failed';
                    DB::table('orders')
                        ->where('id','=', $order_id)
                        ->update([
                            'status'=>$order_status
                        ]);
                }
                $summa = $summa + ($product_quantity * $product_price);
            }
            $user_balance = DB::table('users')
                ->where('id', '=', $user_id)
                ->value('balance');
            if ($order_status == 'failed'){
                $tran_status = 'abort';
            }elseif ($user_balance < $summa){
                $order_status = 'reject';
                $tran_status = 'failed';
                DB::table('orders')
                    ->where('id','=', $order_id)
                    ->update([
                        'status'=>$order_status
                    ]);
            }else{
                $order_status = 'success';
                $tran_status = 'success';
                DB::table('orders')
                    ->where('id','=', $order_id)
                    ->update([
                        'status'=>$order_status
                    ]);
            }
            $tr_id = DB::table('transactions')
                ->insertGetId([
                    'order_id'  => $order_id,
                    'user_id'   => $user_id,
                    'summa'     => $summa,
                    'status'    => $tran_status,
                ]);
            $user_tr_id = DB::table('transactions')
                ->where('id', '=', $tr_id)
                ->where('status', '=', 'success')
                ->value('user_id');
            DB::table('users')
                ->where('id', '=', $user_tr_id)
                ->update([
                   'balance'=> DB::raw('balance - ' . $summa)
                ]);
            $order_tr_id = DB::table('transactions')
                ->where('id', '=', $tr_id)
                ->where('status', '=', 'success')
                ->value('order_id');
            $order_items = DB::table('order_items')
                ->where('order_id', '=', $order_tr_id)
                ->get(['product_id', 'product_quantity', 'product_price']);
            $order_items = json_decode(json_encode($order_items), true);
            for ($l=0; $l<count($order_items); $l++){
                $company_id= DB::table('products')
                    ->where('id','=',$order_items[$l]['product_id'])
                    ->value('company_id');
                DB::table('companys')
                    ->where('id','=',$company_id)
                    ->update([
                        'account_balance'=> DB::raw('account_balance + ' . $order_items[$l]['product_price']*$order_items[$l]['product_quantity'])
                    ]);
                DB::table('products')
                    ->where('id','=',$order_items[$l]['product_id'])
                    ->update([
                        'total_amount'=> DB::raw('total_amount - ' . $order_items[$l]['product_quantity'])
                    ]);
            }
        }
        return response()->json('buyurtmalar yaratildi', 200);
    }
}
