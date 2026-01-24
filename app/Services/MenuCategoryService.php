<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\MenuCategory;

class MenuCategoryService
{
    public static function allCategories()
    {
        return MenuCategory::all();
    }

    public static function show($id)
    {
        return MenuCategory::findOrFail($id);
    }

    public static function showBySlug($slug)
    {
        return MenuCategory::where('slug', $slug)->first();
    }
    
    public static function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $response = MenuCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image->store('menu-categories', 'public'),
        ]);
        
        return redirect()->route('admin.item-category')->with('success', 'Category created successfully');
    }
}
