<?php

namespace Bistro\Banners\Http\Controllers;

use App\Http\Controllers\Controller;
use Bistro\Banners\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        return view('banners::admin.index', compact('banners'));
    }

    public function create(): View
    {
        return view('banners::admin.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'position' => 'required|in:home,category,product',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $validated['image_path'] = $imagePath;
        }

        if ($request->hasFile('mobile_image')) {
            $mobileImagePath = $request->file('mobile_image')->store('banners', 'public');
            $validated['mobile_image_path'] = $mobileImagePath;
        }

        unset($validated['image'], $validated['mobile_image']);

        Banner::create($validated);

        return redirect()->route('admin.banners')
            ->with('success', 'Banner created successfully.');
    }

    public function show(Banner $banner): View
    {
        return view('banners::admin.show', compact('banner'));
    }

    public function edit(Banner $banner): View
    {
        return view('banners::admin.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'position' => 'required|in:home,category,product',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            
            $imagePath = $request->file('image')->store('banners', 'public');
            $validated['image_path'] = $imagePath;
        }

        if ($request->hasFile('mobile_image')) {
            if ($banner->mobile_image_path) {
                Storage::disk('public')->delete($banner->mobile_image_path);
            }
            
            $mobileImagePath = $request->file('mobile_image')->store('banners', 'public');
            $validated['mobile_image_path'] = $mobileImagePath;
        }

        unset($validated['image'], $validated['mobile_image']);

        $banner->update($validated);

        return redirect()->route('admin.banners')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        
        if ($banner->mobile_image_path) {
            Storage::disk('public')->delete($banner->mobile_image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners')
            ->with('success', 'Banner deleted successfully.');
    }

    public function toggleStatus(Banner $banner): RedirectResponse
    {
        $banner->update(['is_active' => !$banner->is_active]);
        
        $status = $banner->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.banners')
            ->with('success', "Banner {$status} successfully.");
    }
}
