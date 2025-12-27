<?php

namespace App\Http\Middleware;

use App\Models\UserLoginActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class LogLoginActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only track login activities for authenticated users
        if (Auth::check() && $this->shouldTrackLogin($request)) {
            $this->logLoginActivity($request);
        }
        
        return $response;
    }
    
    /**
     * Determine if this request should be tracked as a login activity.
     */
    private function shouldTrackLogin(Request $request): bool
    {
        // Track if this is a login attempt or the first request after login
        return $request->is('login') || 
               ($request->session()->has('login_activity_tracked') === false && 
                Auth::check() && 
                !$request->is('logout'));
    }
    
    /**
     * Log the login activity.
     */
    private function logLoginActivity(Request $request): void
    {
        $user = Auth::user();
        $agent = new Agent();
        
        // Parse user agent
        $agent->setUserAgent($request->userAgent());
        
        // Enhanced platform detection for Windows 11
        $platform = $this->getEnhancedPlatform($agent);
        
        UserLoginActivity::create([
            'user_id' => $user->id,
            'ip_address' => $this->getRealIpAddress($request),
            'user_agent' => $request->userAgent(),
            'browser' => $agent->browser() . ' ' . $agent->version($agent->browser()),
            'platform' => $platform,
            'device' => $this->getDeviceType($agent),
            'location' => $this->getLocation($this->getRealIpAddress($request)),
            'successful' => true,
            'login_at' => now(),
            'session_id' => session()->getId(),
        ]);
        
        // Mark that login activity has been tracked for this session
        session(['login_activity_tracked' => true]);
    }
    
    /**
     * Get real client IP address (better than default).
     */
    private function getRealIpAddress(Request $request): string
    {
        // Check for forwarded IP first
        if ($request->header('X-Forwarded-For')) {
            $ips = explode(',', $request->header('X-Forwarded-For'));
            return trim($ips[0]); // First IP is the real client
        }
        
        // Check other common headers
        $headers = [
            'X-Real-IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
        ];
        
        foreach ($headers as $header) {
            if ($request->header($header)) {
                return $request->header($header);
            }
        }
        
        // Fallback to default
        return $request->ip();
    }
    
    /**
     * Get enhanced platform detection with Windows 11 support.
     */
    private function getEnhancedPlatform(Agent $agent): string
    {
        $userAgent = $agent->getUserAgent();
        $platform = $agent->platform();
        $version = $agent->version($agent->platform());
        
        // Detect Windows 11 specifically
        if ($platform === 'Windows' && $version === '10.0') {
            // Check for Windows 11 indicators in user agent
            if (strpos($userAgent, 'Windows NT 10.0') !== false && 
                (strpos($userAgent, 'rv:11.0') !== false || // Edge 11+
                 strpos($userAgent, 'Chrome/9') !== false ||  // Chrome 90+
                 strpos($userAgent, 'Firefox/9') !== false)) { // Firefox 90+
                return 'Windows 11';
            }
        }
        
        // Fallback to original detection
        return $platform . ' ' . $version;
    }
    
    /**
     * Get device type from agent.
     */
    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'Mobile';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isRobot()) {
            return 'Robot';
        } else {
            return 'Desktop';
        }
    }
    
    /**
     * Get location from IP (basic implementation).
     */
    private function getLocation(string $ip): string
    {
        // For now, return a placeholder. You can integrate with a geolocation service
        // like IP-API, MaxMind, or Laravel's built-in location services
        try {
            // Example using IP-API (free tier)
            $response = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);
            
            if ($data['status'] === 'success') {
                return "{$data['city']}, {$data['country']}";
            }
        } catch (\Exception $e) {
            // Fail silently
        }
        
        return 'Unknown';
    }
}
