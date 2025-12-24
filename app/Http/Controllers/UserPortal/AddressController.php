<?php

namespace App\Http\Controllers\UserPortal;

use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Handle default address logic - ensures only one default address per user
     */
    private function handleDefaultAddress($userId, $currentAddressId = null)
    {
        // If setting as default, make all other addresses non-default
        $query = AddressBook::where('user_id', $userId);
        
        // If updating, exclude current address from the query
        if ($currentAddressId) {
            $query->where('id', '!=', $currentAddressId);
        }
        
        $query->update(['is_default' => 0]);
    }

    public function index()
    {
        $addressBooks = AddressBook::where('user_id', Auth::id())->get();
        // dd($addressBooks);
        return view('web.user-portal.address.index', compact('addressBooks'));
    }

    public function create(){
        return view('web.user-portal.address.create');
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|regex:/^[6-9][0-9]{9}$/',
                'address' => 'required|string',
                'address_2' => 'nullable|string',
                'city' => 'required|string|max:100',
                'landmark' => 'required|string|max:255',
                'pincode' => 'required|string|regex:/^[0-9]{6}$/',
                'address_type' => 'required|in:home,work,other',
                'is_default' => 'nullable|boolean'
            ]);

            $addressData = [
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'address' => $validated['address'],
                'address_2' => $validated['address_2'] ?? null,
                'city' => $validated['city'],
                'landmark' => $validated['landmark'] ?? null,
                'pincode' => $validated['pincode'],
                'address_type' => $validated['address_type']
            ];

            $isDefault = $request->has('is_default') ? 1 : 0;
            
            // If setting as default, make all other addresses non-default
            if ($isDefault) {
                $this->handleDefaultAddress(Auth::id());
            }

            AddressBook::create([
                'user_id' => Auth::id(),
                'address' => json_encode($addressData),
                'address_type' => $validated['address_type'],
                'is_default' => $isDefault
            ]);

            return redirect()->route('profile.address-book')->with('success', 'Address added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add address: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $address = AddressBook::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $addressData = json_decode($address->address, true);
        return view('web.user-portal.address.create', compact('address', 'addressData'));
    }

    public function update(Request $request, $id){
        try {
            $address = AddressBook::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|regex:/^[6-9][0-9]{9}$/',
                'address' => 'required|string',
                'address_2' => 'nullable|string',
                'city' => 'required|string|max:100',
                'landmark' => 'required|string|max:255',
                'pincode' => 'required|string|regex:/^[0-9]{6}$/',
                'address_type' => 'required|in:home,work,other',
                'is_default' => 'nullable|boolean'
            ]);

            $addressData = [
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'address' => $validated['address'],
                'address_2' => $validated['address_2'] ?? null,
                'city' => $validated['city'],
                'landmark' => $validated['landmark'] ?? null,
                'pincode' => $validated['pincode'],
                'address_type' => $validated['address_type']
            ];

            $isDefault = $request->has('is_default') ? 1 : 0;
            
            // If setting as default, make all other addresses non-default
            if ($isDefault) {
                $this->handleDefaultAddress(Auth::id(), $address->id);
            }

            $address->update([
                'address' => json_encode($addressData),
                'address_type' => $validated['address_type'],
                'is_default' => $isDefault
            ]);

            return redirect()->route('profile.address-book')->with('success', 'Address updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update address: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $address = AddressBook::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $address->delete();

            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete address: ' . $e->getMessage()
            ], 500);
        }
    }
}
