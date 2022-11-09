<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use PhpParser\Node\Stmt\TryCatch;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $product=[1,2,3,4,5,6];

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'customer' => 'agung',
                'total_amount' => 30000
            ]);
    
            $transaction_details = [];
            foreach ($product as $key => $value) {
                $transaction_details[]=[
                    'transaction_id' => $transaction->id,
                    'product_id' => $value,
                    'quantity' => 9000,
                    'amount' => 1000,
                    'created_at' => Carbon::now()
                ];
            }
            if ($transaction_details){
                TransactionDetail::insert($transaction_details);
            }
            DB::commit();
            return "Succes";
        } catch (\Throwable $th) {
            DB::rollback();
            return "Failed";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
