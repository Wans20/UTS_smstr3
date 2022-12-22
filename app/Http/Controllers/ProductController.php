<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $filter = $request->input('filter');
        $search = $request->input('search');
        //
        //
        //
        //
        $data = Cache::remember('all-product',60, function () use ( $search, $filter){
        $data = product::with(['category']);

        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                      ->orWhere('status','like', "%$search%");
            });
        }

        if($filter) {
            $data->where(function ($query) use ($filter){
                $query->where('category_id','=',$filter);
            });
        }
        return $data->get();
    });
        // $data = $data->paginate(15);
        // //ditambahkan with sebelum get untuk memanggil public function major di anggota.php
        return view('admin.pages.product.list', compact('data'),[
            'judul' => 'list product',
    ]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        $categories = category::get();
        return view('pages.product.form',[
            'product' => $product,
            'categories'=>$categories,
            'judul'=>"Form Create Product"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            $data['image'] = $image->store('images/product', 'public');
        }
        $data['image'] = $request->file('image')->store('images/product','public');
        // dd($data);
        Product::create($data);
        return redirect('product')->with('notif', 'Data Berhasil Masuk');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories = category::get();
        return view('pages.product.form',[
            'product' => $product,
            'categories'=>$categories,
            'judul'=>"Form Edit Product"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            $exists =  File::exists(storage_path('app/public/').$product->image);
            if($exists){
                File::delete(storage_path('app/public/').$product->image);
            }
            $data['image']=($request->file('image')->store('public/images','public'));
        }
        $product->update($data);
        return redirect()->route('product.index')->with('notif','berhasil update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $exists = File::exists(storage_path('app/publuc/').$product->image);
        if($exists){
            File::delete(storage_path('app/public/').$product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('notif','berhasil hapus data');
    }
}
