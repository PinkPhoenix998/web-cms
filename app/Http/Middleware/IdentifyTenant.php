<?php

namespace App\Http\Middleware;

use App\Models\School;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// File: App\Http\Middleware\IdentifyTenant.php

// ... (use statements)

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        // [SOLUSI AKHIR SQL ERROR]: Segera lewati jika ini adalah rute Admin Panel.
        // Tidak perlu memproses pathSegments jika rutenya adalah 'admin'.
        if ($request->is('admin*')) {
            app()->forgetInstance('currentSchool'); // Pastikan tidak ada sisa konteks tenant
            return $next($request);
        }

        $pathSegments = explode('/', $request->path());
        
        // Cek apakah URL dimulai dengan '/s/' dan segmen slug ada
        $isTenantRoute = count($pathSegments) > 1 && $pathSegments[0] === 's' && isset($pathSegments[1]);

        if ($isTenantRoute) {
            $schoolSlug = $pathSegments[1];
            
            $school = School::where('slug', $schoolSlug)->first();

            if ($school) {
                app()->instance('currentSchool', $school);
                return $next($request);
            }
            
            return response()->view('errors.tenant-not-found', [], 404);
        }

        // Jika URL bukan rute tenant, hapus konteks
        app()->forgetInstance('currentSchool');
        
        return $next($request);
    }
}