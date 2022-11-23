<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Ramsey\Uuid\Uuid;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function list(Request $request)
    {

        $limit = $request->input('limit');

        return Transaction::with(['details'])->paginate($limit);
    }

    public function detail(Request $request,$id)
    {
        //cara 1
        return Transaction::with(['details'])->find($id);
        //cara 2
        // return Transaction::with(['details'])->where('id',$id)->first();
    }

    public function store(Request $request)
    {
        $params = $request->all();
        //cara ambil id nya aja, pakai laravel colection
        $productIds = collect($params['products'])->pluck('id');
        //cara panggil id nya aja, pakai manual
        // [1, 2, 3]
        // select * from product where id = 1 or id = 2 or id = 3 or id =.....or id =1000
        // select * from product where id in[1,2,3,...,1000]
        $products = Product::whereIn('id', $productIds)->get();
        // $products : [
        //     {
        //         "id" : 1,
        //         "price : x,  
        //         "name" : x
        //     },
        //     {
        //         "id" : 2,
        //         "price : x,  
        //         "name" : x
        //     }
        // ]
        $total_amount = 0;
        foreach ($params['products'] as $value){
            $product = $products->firstWhere('id', $value['id']);
            // $total_amount = $total_amount + 1;
            // $total_amount += 1;
            $total_amount += ($product ? $product->price : 0)* $value['qty'];
        }
        //mulai session untuk query transaction
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'customer' => $params['customer_name'],
                'total_amount' => $total_amount
            ]);
    
            $transaction_details = [];
            foreach ($params['products'] as $key => $value) {
                $product = $products->firstWhere('id', $value['id']);
                $transaction_details[]=[
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => $transaction->id,
                    'product_id' => $value['id'],
                    'quantity' => $value['qty'],
                    'amount' => $product ? $product->price : 0,
                    'created_at' => Carbon::now()
                ];
            }
            if ($transaction_details){
                TransactionDetail::insert($transaction_details);
            }
            DB::commit();
            return $transaction;
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }
}
