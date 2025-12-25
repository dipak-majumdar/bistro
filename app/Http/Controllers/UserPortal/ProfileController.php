<?php

namespace App\Http\Controllers\UserPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('web.user-portal.profile.edit')
            ->with('user', $request->user())
            ->with('mustVerifyEmail', $request->user() instanceof MustVerifyEmail)
            ->with('status', session('status'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        try {
            // Get validated data
            $validated = $request->validated();
            
            $user = $request->user();
            
            
            // Update user data
            $user->name = $validated['name'];
            
            
            // Save the user
            $user->save();
            
            return redirect()->route('profile.edit')
                ->with('success', 'Profile updated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again. ' . $e->getMessage());
        }
    }

    /**
     * Update the user's profile information.
     */
    public function emailUpdate(Request $request): RedirectResponse
    {

        try {
            // Get validated data
            $validated = $request->validated();
            
            $user = Auth::user();
            $userOldEmail = Auth::user()->email;
            
            // Check if email is being updated
            $emailChanged = $userOldEmail !== $validated['email'];
            
            
            if ($emailChanged) {
                $user->email_verified_at = null;
            }
            
            // Save the user
            $user->save();

            // Send verification email if email was changed
            if ($emailChanged) {
                $user->sendEmailVerificationNotification();
                return redirect()->route('profile.edit')
                    ->with('status', 'verification-link-sent')
                    ->with('success', 'Email updated! Please verify your new email address.');
            }
            
            return redirect()->route('profile.edit')
                ->with('success', 'Email updated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update email. Please try again. ' . $e->getMessage());
        }
    }

    public function privacy(): View
    {
        return view('web.user-portal.privacy');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
