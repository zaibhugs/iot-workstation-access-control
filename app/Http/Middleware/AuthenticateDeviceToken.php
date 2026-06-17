<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateDeviceToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token=$request->header('X-Device-Token');
        if (!$token ) {
            return response()->json([
                'success' => false,
                'message' => 'Device token is required',
            ], 401);
        }

        $device = Device::where('api_token',$token)->first();


        if (!$device || !$device->isTokenValid()){
            return response()->json([
                'success'=>false,
                'message'=>'Access Denied: Invalid or expired device token.'
            ], 401);
        }
        $request->merge(['authenticated_device' => $device]);
        return $next($request);
    }
}
