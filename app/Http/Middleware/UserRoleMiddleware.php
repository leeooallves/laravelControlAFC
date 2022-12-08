<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,  $role)
    {
        if (!$request->user()) {
            return response()->json(['status' => 403, 'message' => 'Erro', 'records' => null]);
        }

        $user = $request->user();

        if (mb_strpos($role, '|') !== false) {
            $role = explode('|', $role);
            if (!in_array($user->is_permission, $role)) {
                return response()->json(['status' => 403, 'message' => 'permissão negada!', 'records' => null]);
            }
        } else {
            if ($user->is_permission != $role) {
                return response()->json(['status' => 403, 'message' => 'permissão negada!', 'records' => null]);
            }
        }

        return $next($request);
    }
}
