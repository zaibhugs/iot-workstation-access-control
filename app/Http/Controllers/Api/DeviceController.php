<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceController extends Controller
{
    public function activate(Request $request)
    {
        $validated = $request->validate([
            'device_uid'   => 'required|string',
            'pairing_code' => 'required|string', 
        ]);

        
        $device = Device::where('device_uid', $validated['device_uid'])
                        ->where('pairing_code', $validated['pairing_code'])
                        ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Device UID or Pairing Code.'
            ], 404);
        }

        
        $device->update([
            'is_active' => true,
            'last_seen_at' => now(),
            'pairing_code' => null, 
        ]);

        
        $token = $device->api_token ?? $device->generateApiToken();

        return response()->json([
            'success' => true,
            'message' => 'Device successfully linked and activated!',
            'token' => $token,
        ], Response::HTTP_OK);
    }
}
