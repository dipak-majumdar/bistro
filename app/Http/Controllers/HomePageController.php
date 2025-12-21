<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Services\MenuItemService;
use App\Services\MenuCategoryService;
use App\Models\MenuCategory;

class HomePageController extends Controller
{

    public function __construct(
        protected MenuItemService $menuItemService,
        protected MenuCategoryService $menuCategoryService
    ) {
    }

    public function homePage()
    {
        try {
            $menuItems = $this->menuItemService->index();
            $categories = $this->menuCategoryService->index();
            $mostOrderedItems = $this->menuItemService->mostOrderedItems(6);
            $categoryWithItems = MenuCategory::with(['items' => function($query) {
                $query->with('images')->orderBy('id', 'desc')->limit(4);
            }])->whereHas('items')->get();
            
            return view('web.home', [
                'items' => $menuItems['menuItems'],
                'categories' => $categories,
                'mostOrderedItems' => $mostOrderedItems,
                'categoryWithItems' => $categoryWithItems
            ]);
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Failed to load home page data: ' . $e->getMessage());
            return view('web.home', [
                'items' => [],
                'categories' => [],
                'error' => 'Unable to load menu data. Please try again later.'
            ]);
        }
    }

    public function itemDetails($id)
    {
        try {
            $menuItem = $this->menuItemService->show($id);
            if (!$menuItem) {
                return response()->json([
                    'error' => 'Item not found.'
                ], 404);
            }
            return response()->json($menuItem);
        } catch (\Exception $e) {
            Log::error('Failed to load item details: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unable to load item details. Please try again later.'
            ]);
        }
    }

    public function aboutPage(){
        return view('web.about');
    }

    public function contactPage(){
        return view('web.contact');
    }

    public function privacyPolicyPage(){
        return view('web.privacy-policy');
    }

    public function termsConditionsPage(){
        return view('web.terms');
    }
    
}
