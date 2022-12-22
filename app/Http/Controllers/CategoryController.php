<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = category::get();
        return view('admin.pages.category.list',[
            'data'=>$data,
            'judul'=>"category product"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = new category();
        return view('admin.pages.category.form',[
            'category' => $category,
            'judul'=>"Form Create category"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecategoryRequest $request)
    {
        //
        $data = $request->all();
        category::create($data);
        return redirect('category')->with('notif', 'Data Berhasil Masuk');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        $categories = $category->load(['products']);
        return view('admin.pages.category.list-product', compact('category'),
        ['judul'=> 'list barang']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
        return view('admin.pages.category.form',[
            'category' => $category,
            'judul'=>"Form Edit Category"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecategoryRequest  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecategoryRequest $request, category $category)
    {
        //untuk menampilkan value database
        $data = $request->all();
        //untuk menyimpan data setelah update
        $category->update($data);

        return redirect()->route('category.index')->with('notif','berhasil update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
        $category->delete();
        return redirect()->route('category.index')->with('notif','data berhasil di hapus');
    }
}
