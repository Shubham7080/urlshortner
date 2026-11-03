<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('users')
            ->latest()
            ->paginate(10);

        return view('dashboards.superadmin', compact('companies'));
    }

    
    public function companyAdmin()
    {
        $user = auth()->user();

        if (!$user->company_id) {
            abort(403, 'You are not assigned to a company.');
        }

        $teamMembers = \App\Models\User::where(
            'company_id',
            $user->company_id
        )
            ->latest()
            ->paginate(10);

        return view('dashboards.company-admin', compact('teamMembers'));
    }

   public function redirectByRole()
{
    $user = auth()->user();

    if ($user->hasRole('SuperAdmin')) {
        return redirect()->route('dashboard');
    }

    if ($user->hasRole('Admin')) {
        return redirect()->route('company-dashboard');
    }

    if ($user->hasRole('Member')) {
        return redirect()->route('short-urls.index');
    }

    abort(403, 'You do not have an assigned role.');
}
}