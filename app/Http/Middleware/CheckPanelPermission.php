<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPanelPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $panel)
    {
        $user = Auth::user();

        // Mapping izin berdasarkan panel
        $permissions = [
            'admin' => 'can_access_panel_admin',
            'curriculum' => 'can_access_panel_curriculum',
            'admission' => 'can_access_panel_admission',
            'teacher' => 'can_access_panel_teacher',
            'teacher_pg_kg' => 'can_access_panel_teacher_pg_kg',
        ];

        // Cek apakah user memiliki izin untuk panel tersebut
        if ($user && isset($permissions[$panel]) && $user->can($permissions[$panel])) {
            return $next($request);
        }

        // Jika tidak memiliki izin, arahkan ke halaman 403 Unauthorized
        abort(403, 'Unauthorized');
    }
}
