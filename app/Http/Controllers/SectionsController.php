<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SectionsRequest;
use App\Sections;
use Illuminate\Support\Facades\Crypt;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       $sections = Sections::select('id', 'name', 'description')->get();
        
        return view('sections.index', compact('sections'));
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
    public function store(SectionsRequest $request)
    {
        
        Sections::create([
            'name' => $request->name,
            'description' => $request->description,
            'user' => auth()->user()->name
        ]);
        
        return redirect()->back()->with(['success' => 'تم إضافة القسم بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:sections,name,' . $request->id
        ]);
        
        Sections::findOrFail($request->id);
        
        Sections::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        
        return redirect()->back()->with(['success' => 'تم تعديل القسم بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Sections::findOrFail($request->id);
        
        Sections::where('id', $request->id)->delete();
        
        return redirect()->back()->with(['success' => 'تم حذف القسم بنجاح']);
    }
}
