<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pengguna = session('user');
        $role = $pengguna->role->nama_role;

        $routes = [
            'Owner' => [
                'allowed_routes' => [ 
                    'dashboard',
                    'pengguna.index', 'pengguna.create', 'pengguna.show', 'pengguna.edit', 'pengguna.delete',
                    'customer.index', 'customer.create', 'customer.show', 'customer.edit', 'customer.delete',
                    'product.index', 'product.create', 'product.show', 'product.edit', 'product.delete',
                    'sales.index', 'sales.create', 'sales.show', 'sales.detail',
                    'poin.index', 'poin.penukaran', 'poin.show', 'logout',
                ],
            ],
            'Manajer' => [
                'allowed_routes' => [ 
                    'dashboard',
                    'customer.index', 'customer.create', 'customer.show', 'customer.edit', 
                    'product.index', 'product.create', 'product.show', 'product.edit', 
                    'sales.index', 'sales.create', 'sales.show', 'sales.detail',
                    'poin.index', 'poin.penukaran', 'poin.show', 'logout',
                ],
            ],
            'Pegawai' => [
                'allowed_routes' => [ 
                    'dashboard',
                    'customer.index', 'customer.create', 'customer.show', 'customer.edit', 
                    'sales.index', 'sales.create', 'sales.show', 'sales.detail',
                    'poin.index', 'poin.penukaran', 'poin.show', 'logout',
                ],
            ],
        ];

        if(!isset($routes [$role])) {
            return redirect()->route('login')->with([
                'message' => 'Peran tidak dikenal!',
                'alert-type' => 'error'
            ]);
        }

        $currentRouteName = $request->route()->getName();

        if(isset($routes[$role]['allowed_routes']) && !in_array($currentRouteName, $routes[$role]['allowed_routes'])) {
            return redirect()->back()->with([
                'message' => 'Anda tidak memiliki hak akses ini!',
                'alert-type' => 'warning'
            ]);
        }

        return $next($request);

    }
}
