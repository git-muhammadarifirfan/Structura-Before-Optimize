<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        if ($request->is('structuradmin') || $request->is('structuradmin/*')) {
            return url('/structuradmin/login');;
        }

        // Default redirect kalau bukan akses admin
        return route('login');
    }
}
