<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockDemoAdminWrites
{
    public const DEMO_ADMIN_EMAIL = 'demo.admin@stayswift.test';

    private const BLOCKED = [
        'addRoom', 'updateRoom',
        'deactivateRoom', 'activateRoom',
        'deactivateCustomer', 'activateCustomer',
        'deleteUnpaidReservation',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->guard('userModel')->user();

        if ($user && $user->email === self::DEMO_ADMIN_EMAIL
            && in_array($request->route()?->getName(), self::BLOCKED, true)) {
            return response()->json([
                'demo_restricted' => true,
                'message' => 'This action is disabled in demo mode.',
            ], 403);
        }

        return $next($request);
    }
}