<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\checkout;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StorecheckoutRequest;
use App\Http\Requests\UpdatecheckoutRequest;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::paginate(100);
        return view('admin.pages.checkout.product', compact('data'), [
            'title' => 'List Product',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $productID = $request->input('product_id');
        $qty = (int) $request->input('qty', 1);
        $checkout = [
            'products' => [],
            'user' => [
                "name" => "",
                "address" => ""
            ],
        ];
        $data = Cache::get('checkout', $checkout);
        $temp = null;
        if (isset($data['products'][$productID])) {
            $temp =  [
                "id" => $productID,
                "qty" => $qty + $data['products'][$productID]['qty']
            ];
        } else {
            $temp =  [
                "id" => $productID,
                "qty" => $qty
            ];
        }
        $data['products'][$productID] = $temp;

        Cache::put('checkout', $data);
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecheckoutRequest $request)
    {
        $data = $request->all();
        $productIds = $request->input('product_id');
        $prices = $request->input('price');
        $qty = $request->input('qty');

        $product = Product::whereIn('id', $productIds)->get();

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'customer' => $data['customer_name'],
                'total_amount' => $data['total_amount'],
            ]);
    
            $transaction_details = [];
            foreach ($productIds as $key => $value) {
                $product = $product->firstWhere('id', $value);
                $transaction_details[]=[
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'quantity' => $qty[$key],
                    'amount' => $prices[$key],
                    'created_at' => Carbon::now()
                ];
            }
            if ($transaction_details){
                TransactionDetail::insert($transaction_details);
            }
            // biki transaction di midtrans
            $paymentUrl = $this->createInvoice($transaction);

            DB::commit();
            return $paymentUrl;
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function createInvoice($transaction){

        //set konnfigrasi midtrans ngambil dari config/midrtrans.php
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // buat params untuk dikirim ke midtrans
        $midtrans_params = [
            'transaction_details' =>[
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total_amount //ditetapkan harus int yang dikirim
            ],
            'customer_details' =>[
                'first_name' => $transaction->customer,
                'email' => "wans200102@gmail.com",
            ],
        ];
$paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
        return $paymentUrl;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecheckoutRequest  $request
     * @param  \App\Models\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecheckoutRequest $request, checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(checkout $checkout)
    {
        //
    }

    public function chart()
    {
        $data = Cache::get('checkout');
        $id = [];
        $qty = [];
        $prices = [];

        foreach($data['products'] as $product){
            $id[] = $product['id'];
            $qty[] = $product['qty'];
        }

        $products = Product::whereIn('id', $id)->get();

        foreach($products as $product){
            $prices[] = $product->price;
        }

        $totalPrice = 0;

        foreach($prices as $key => $price){
            $totalPrice += $price * $qty[$key];
        }
        return view('admin.pages.checkout.chart', compact('data'), [
            'title' => 'My Chart',
            'products' => $products,
            'totalPrice' => $totalPrice
        ]);
    }
}
