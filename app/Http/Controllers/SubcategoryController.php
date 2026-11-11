<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = Subcategory::with('category')->latest()->paginate(10);
        return view('crm_emanager.backend.admin.subcategory.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('crm_emanager.backend.admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=> 'required|string|max:255|unique:subcategories,name',
            'category_id'=> 'nullable',
            'description' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Subcategory::create($validated);
        return redirect()->route('subcategory.index')->with('success', 'Subcategory Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
       $categories = Category::all();
        return view('crm_emanager.backend.admin.subcategory.edit', compact('categories', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
       $validated = $request->validate([
            'name'=> 'required|string|max:255',
            'category_id'=> 'nullable',
            'description' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

      $subcategory->update($validated);
        return redirect()->route('subcategory.index')->with('success', 'Subcategory Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted Successfully');

    }
}
