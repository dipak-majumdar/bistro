<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\AppController;
use Illuminate\Support\Str;
use Nette\Utils\Json;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (Auth::check()) {
            return redirect()->intended(route('home', absolute: false));
        }
        return view('web.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        AppController::updateCartUserIdForGuest(AppController::getGuestId(), Auth::id());
        
        return redirect()->intended(route('home', absolute: false));
    }

    public static function getGuestId(){
        if (!request()->cookie('guest_identifier')) {
            $guestId = Str::uuid()->toString();
            cookie()->queue('guest_identifier', $guestId, 7 * 24 * 60); // 7 days in minutes
        }
        return request()->cookie('guest_identifier');
    }

    /**
     * Check if the user is logged in.
     */
    public static function isLoggedIn(){
        
        return response()->json(['is_logged_in' => Auth::check()]);
    }

    /**
     * Get the user ID.
     */
    public static function userId(){
        $userId = Auth::check() ? Auth::id() : self::getGuestId();
        return response()->json(['user_id' => $userId]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
