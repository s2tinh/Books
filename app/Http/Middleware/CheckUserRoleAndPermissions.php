<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRoleAndPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @param  array|null  $permissions
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role, ...$permissions)
    {
        // Kiểm tra xem người dùng có đăng nhập hay không
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Kiểm tra xem người dùng có role yêu cầu không
        if (!$this->userHasRole($request->user(), $role)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Kiểm tra xem người dùng có những permissions yêu cầu không
        if (!$this->userHasPermissions($request->user(), $permissions)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }

    /**
     * Kiểm tra xem người dùng có role yêu cầu không
     *
     * @param  \App\Models\User $user
     * @param  string $role
     * @return bool
     */
    protected function userHasRole($user, $role)
    {
        return $user->hasRole($role);
    }

    /**
     * Kiểm tra xem người dùng có những permissions yêu cầu không
     *
     * @param  \App\Models\User $user
     * @param  array $permissions
     * @return bool
     */
    protected function userHasPermissions($user, $permissions)
    {
        $userPermissions = $user->permissions->pluck('name')->toArray();

        // Kiểm tra nếu tất cả permissions yêu cầu đều có trong quyền của người dùng
        return empty(array_diff($permissions, $userPermissions));
    }
}
