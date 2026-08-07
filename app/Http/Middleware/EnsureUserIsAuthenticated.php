<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleHasPermission;
use App\Models\Permission;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     */
  

	public function handle(Request $request, Closure $next): mixed
	{
		$user = Auth::user();  

		if (!$user) {
			return redirect()->route('login');
		}

		$role_id = $user->role_id;

		$urls = [];

		// Define role groups
		$accounts = [7, 8, 9, 4, 5, 6, 10, 11, 12, 13, 14, 15, 16, 17, 18]; // Same URLs
		$broker = [19, 20, 21];
		$admin = [1, 2, 3, 22];

		// Assign URLs based on role
		if (in_array($role_id, $accounts)) {
			$urls = ['account', 'broker', 'file', 'files', 'remaing'];
		} elseif (in_array($role_id, $broker)) {
			$urls = ['broker', 'file', 'files', 'remaing'];
		} elseif (in_array($role_id, $admin)) {
			$urls = ['admin', 'broker', 'account', 'file', 'files', 'remaing'];
		}

		// Get the first segment of the requested URL
		$firstSegment = $request->segment(1);
		$isSharedLoadRoute = $firstSegment === 'admin' && ($request->is('admin/load/edit/*') || $request->is('admin/load/update/*'));
		// Check permission
		if (!in_array($firstSegment, $urls) && !($isSharedLoadRoute && in_array($role_id, $accounts))) {
			abort(404); // Permission denied
		}

		return $next($request);
	}

}
