<?php

namespace App\Http\Controllers;

use App\Products;
use App\Sections;
use App\Http\Requests\ProductsRequest;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::select('id', 'product_name', 'description', 'section_id')->get();

        $sections = Sections::select('id', 'name')->get();

        return view('products.index')->with([
            'products' => $products,
            'sections' => $sections
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        Sections::findorFail($request->section_id);
        
        Products::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id
        ]);

        return redirect()->back()->with(['success' => 'تم إضافة المنتج بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required|max:255|unique:products,product_name,' . $request->id
        ]);
        
        Sections::findorFail($request->section_id);

        Products::findOrFail($request->id);
        
        Products::where('id', $request->id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id
        ]);

        return redirect()->back()->with(['success' => 'تم تحديث المنتج بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Products::findOrFail($request->id);

        Products::where('id', $request->id)->delete();

        return redirect()->back()->with(['success' => 'تم حذف المنتج بنجاح']);
    }
}
