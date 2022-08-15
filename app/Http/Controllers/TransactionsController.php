<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
class TransactionsController extends BaseController
{
//    public function test(Request $request){
//        $order_tr_id = $request->get('order_id');
//        $order_items = DB::table('order_items')
//            ->where('order_id', '=', $order_tr_id)
//            ->get(['product_id', 'product_quantity', 'product_price']);
//        $order_items_array = json_decode(json_encode($order_items), true);
//        return response()->json($order_items_array[0]['product_id'], 200);
//    }
}
