<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeComponents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class HomeLayoutController extends Controller
{
    /**
     * Display a listing of home layouts.
     */
    public function index(): View
    {
        // 1. Define the path using the helper
        $path = resource_path('views/components/web/home');

        // 2. Check if directory exists to avoid errors
        $componentFiles = [];
        if (File::isDirectory($path)) {
            
            // Get an array of SplFileInfo objects
            $files = File::files($path);

            foreach ($files as $file) {
                // Get filename without .blade.php extension
                $filename = str_replace('.blade', '', pathinfo($file->getFilename(), PATHINFO_FILENAME));
                
                // Create object with id and name as the filename
                $componentFiles[] = (object)[
                    'id' => $filename,
                    'name' => $filename
                ];
            }
        }

        // dd($componentFiles);

        $components = HomeComponents::get();

        return view('admin.home-layout.index', compact('components', 'componentFiles'));
    }

    /**
     * Show the form for creating a new home layout.
     */
    public function create(): RedirectResponse
    {
        // Available components that can be added to layouts
        $availableComponents = [
            'top-categories' => 'Top Categories',
            'single-image-banner' => 'Single Image Banner',
            'most-ordered-items' => 'Most Ordered Items',
            'featured-products' => 'Featured Products',
            'testimonials' => 'Testimonials',
            'newsletter' => 'Newsletter Signup',
            'recent-orders' => 'Recent Orders',
        ];

        return redirect()->route('admin.home-component');
    }

    /**
     * Store a newly created home layout in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'component' => 'required|string',
                'is_active' => 'boolean'
            ]);

            // Set default values
            $validated['is_active'] = $request->has('is_active');
            
            HomeComponents::create($validated);

            return redirect()
                ->route('admin.home-component')
                ->with('success', 'Home layout created successfully.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($e->errors());
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
                
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return redirect()
            //     ->back()
            //     ->with('error', 'Failed to create home layout: ' . $e->getMessage())
            //     ->withInput();
        }
    }
    
    /**
     * Update the specified home layout in storage.
     */
    public function update(Request $request, HomeComponents $homeLayout): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:home_components,name,' . $homeLayout->id,
            'components' => 'nullable|array',
            'components.*' => 'string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');

        $homeLayout->update($validated);

        return redirect()
            ->route('admin.home-component')
            ->with('success', 'Home layout updated successfully.');
    }

    /**
     * Remove the specified home layout from storage.
     */
    public function destroy(HomeComponents $homeLayout): RedirectResponse
    {
        $homeLayout->delete();

        return redirect()
            ->route('admin.home-component')
            ->with('success', 'Home layout deleted successfully.');
    }

    /**
     * Update the order of home layouts.
     */
    public function updateOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'layouts' => 'required|array',
            'layouts.*.id' => 'required|exists:home_layouts,id',
            'layouts.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($validated['layouts'] as $layoutData) {
            HomeComponents::where('id', $layoutData['id'])
                ->update(['sort_order' => $layoutData['sort_order']]);
        }

        return redirect()
            ->route('admin.home-component')
            ->with('success', 'Layout order updated successfully.');
    }

    /**
     * Toggle the active status of a home layout.
     */
    public function toggleStatus(HomeComponents $homeLayout): RedirectResponse
    {
        $homeLayout->update(['is_active' => !$homeLayout->is_active]);

        $status = $homeLayout->is_active ? 'activated' : 'deactivated';

        return redirect()
            ->route('admin.home-component')
            ->with('success', "Home layout {$status} successfully.");
    }
}
