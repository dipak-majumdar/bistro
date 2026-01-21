<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\HomeComponents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getComponentById($componentId)
    {
        try {
            if (empty($componentId)) {
                throw new \Exception('Component ID is required');
            }

            $components = HomeComponents::find($componentId);
            
            if (!$components) {
                throw new \Exception('Component not found');
            }

            return response()->json(['data' => $components], 200);
        } catch (\Exception $e) {
            $statusCode = 500;
            $message = 'An error occurred while fetching the component';
            
            if (str_contains($e->getMessage(), 'Component ID is required')) {
                $statusCode = 400;
                $message = $e->getMessage();
            } elseif (str_contains($e->getMessage(), 'Component not found')) {
                $statusCode = 404;
                $message = $e->getMessage();
            }
            
            return response()->json(['message' => $message, 'error' => $e->getMessage()], $statusCode);
        }
    }

    public function getComponentByName($componentName)
    {
        try {
            if (empty($componentName)) {
                throw new \Exception('Component name is required');
            }

            $component = HomeComponents::where('component', $componentName)->first();
            
            if (!$component) {
                throw new \Exception('Component not found');
            }

            return response()->json(['data' => $component], 200);
        } catch (\Exception $e) {
            $statusCode = 500;
            $message = 'An error occurred while fetching the component';
            
            if (str_contains($e->getMessage(), 'Component name is required')) {
                $statusCode = 400;
                $message = $e->getMessage();
            } elseif (str_contains($e->getMessage(), 'Component not found')) {
                $statusCode = 404;
                $message = $e->getMessage();
            }
            
            return response()->json(['message' => $message, 'error' => $e->getMessage()], $statusCode);
        }
    }

    /**
     * Update the specified component.
     */
    public function updateComponent(Request $request, $componentId)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'component' => 'required|string',
                'is_active' => 'boolean'
            ]);

            $component = HomeComponents::find($componentId);
            
            if (!$component) {
                return response()->json(['message' => 'Component not found'], 404);
            }

            $component->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Component updated successfully',
                'data' => $component
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update component: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $component = HomeComponents::find($id);
            
            if (!$component) {
                return response()->json(['success' => true, 'message' => 'Component not found'], 404);
            }

            $component->delete();
            return response()->json(['success' => true, 'message' => 'Component deleted successfully']);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete component: ' . $e->getMessage()
            ], 500);
        }
    }
}
