<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Services\MenuItemService;
use App\Services\MenuCategoryService;

class CategoryPageController extends Controller
{

    public function __construct(
        protected MenuItemService $menuItemService,
        protected MenuCategoryService $menuCategoryService
    ) {
    }
  

    public function categoryDetails($slug)
    {
        try {
            $categories = MenuCategoryService::allCategories();
            $categoryDetails = MenuCategoryService::showBySlug($slug);
            $menuItemsQuery = MenuItemService::itemsByCategory($categoryDetails->id);
            
            // Get first 12 items for initial load
            $initialItems = $menuItemsQuery->take(12)->get();
            $totalItems = $menuItemsQuery->count();
            
            return view('web.category-details', [
                'categories' => $categories,
                'category' => $categoryDetails,
                'menuItems' => $initialItems,
                'totalItems' => $totalItems,
                'categoryId' => $categoryDetails->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load category page data: ' . $e->getMessage());
            return view('web.category-details', [
                'categories' => [],
                'category' => [],
                'menuItems' => [],
                'totalItems' => 0,
                'categoryId' => null,
                'error' => 'Unable to load category data. Please try again later.'
            ]);
        }
    }

    public function loadMoreItems(Request $request)
    {
        try {
            $categoryId = $request->input('category_id');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 12);
            
            $menuItemsQuery = MenuItemService::itemsByCategory($categoryId);
            $totalItems = $menuItemsQuery->count();
            
            $items = $menuItemsQuery->skip($offset)->take($limit)->get();
            
            return response()->json([
                'success' => true,
                'items' => $items,
                'hasMore' => $totalItems > ($offset + $limit)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load more items'
            ], 500);
        }
    }
}