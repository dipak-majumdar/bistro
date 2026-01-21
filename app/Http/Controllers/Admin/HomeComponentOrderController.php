<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeComponents;
use App\Models\HomeComponentOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class HomeComponentOrderController extends Controller
{
    /**
     * Display a listing of home component orders.
     */
    public function index(): View
    {
        // Get only components that have orders, ordered by sort_order
        $components = HomeComponents::whereHas('componentOrders')
            ->join('home_components_order', 'home_components.id', '=', 'home_components_order.layout_id')
            ->orderBy('home_components_order.sort_order', 'asc')
            ->select('home_components.*', 'home_components_order.sort_order as component_sort_order')
            ->get()
            ->sortBy('component_sort_order');

        // Get available component files from database
        $availableComponents = HomeComponents::get();

        return view('admin.home-layout.component-order', compact('components', 'availableComponents'));
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
            return redirect()
                ->back()
                ->with('error', 'Failed to create home layout: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Update the order of home components.
     */
    public function updateOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validate([
                'components' => 'required|array',
                'components.*' => 'required|exists:home_components,id'
            ]);

            // Clear existing orders
            HomeComponentOrder::truncate();

            // Create new orders based on the submitted order
            foreach ($validated['components'] as $index => $componentId) {
                HomeComponentOrder::create([
                    'layout_id' => $componentId,
                    'sort_order' => $index+1
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Component order updated successfully.',
                'redirect' => route('admin.component-orders')
            ]);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update component order: ' . $e->getMessage()
            ], 500);
        }
    }
}
