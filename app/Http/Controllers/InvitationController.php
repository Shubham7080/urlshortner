<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
     public function create()
    {
        $user = auth()->user();

        if ($user->company_id === null) {
            return view('invitations.create-client');
        }

        return view('invitations.create-member');
    }

     
public function store(Request $request)
{
    $user = $request->user();

    // Temporary flow selection until role authorization is implemented.
    if ($user->company_id === null) {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', Rule::in(['Admin'])],
        ]);

        $company = null;
        $name = null;
    } else {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', Rule::in(['Admin', 'Member'])],
        ]);

        $company = $user->company;
        $name = $validated['name'];
    }

    $token = Str::random(64);

    DB::transaction(function () use (
        $validated,
        $user,
        &$company,
        $token,
        $name
    ) {
        if ($company === null) {
            $company = Company::create([
                'name' => $validated['company_name'],
                'slug' => $this->generateUniqueSlug(
                    $validated['company_name']
                ),
            ]);
        }

        Invitation::create([
            'company_id' => $company->id,
            'invited_by' => $user->id,
            'email' => $validated['email'],
            'name' => $name,
            'role' => $validated['role'],
            'token_hash' => hash('sha256', $token),
            'expires_at' => now()->addDays(7),
        ]);
    });

    $invitationUrl = url('/invitations/accept/' . $token);

    return redirect()
        ->route('invitations.create')
        ->with('success', 'Invitation created successfully.')
        ->with('invitation_url', $invitationUrl);
}


    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (Company::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    
public function accept(string $token)
{
    $invitation = Invitation::where(
        'token_hash',
        hash('sha256', $token)
    )->first();

    if (!$invitation) {
        return view('invitations.accept', [
            'invitation' => null,
            'error' => 'This invitation link is invalid.',
        ]);
    }

    if ($invitation->accepted_at !== null) {
        return view('invitations.accept', [
            'invitation' => null,
            'error' => 'This invitation has already been accepted.',
        ]);
    }

    if ($invitation->expires_at->isPast()) {
        return view('invitations.accept', [
            'invitation' => null,
            'error' => 'This invitation has expired.',
        ]);
    }

    return view('invitations.accept', [
        'invitation' => $invitation,
        'error' => null,
    ]);
}

public function acceptStore(Request $request, string $token)
{
    $user = $request->user();

    $invitation = Invitation::where(
        'token_hash',
        hash('sha256', $token)
    )->first();

    if (!$invitation) {
        return back()->withErrors([
            'invitation' => 'This invitation link is invalid.',
        ]);
    }

    if ($invitation->accepted_at !== null) {
        return back()->withErrors([
            'invitation' => 'This invitation has already been accepted.',
        ]);
    }

    if ($invitation->expires_at->isPast()) {
        return back()->withErrors([
            'invitation' => 'This invitation has expired.',
        ]);
    }

    if (strtolower($user->email) !== strtolower($invitation->email)) {
        return back()->withErrors([
            'invitation' => 'Please log in using the email address that received this invitation.',
        ]);
    }

    if (
        $user->company_id !== null &&
        $user->company_id !== $invitation->company_id
    ) {
        return back()->withErrors([
            'invitation' => 'You already belong to another company.',
        ]);
    }

    DB::transaction(function () use ($invitation, $user) {
        $lockedInvitation = Invitation::whereKey($invitation->id)
            ->lockForUpdate()
            ->firstOrFail();

        if (
            $lockedInvitation->accepted_at !== null ||
            $lockedInvitation->expires_at->isPast()
        ) {
            throw new \RuntimeException(
                'This invitation is no longer available.'
            );
        }

        $user->company_id = $lockedInvitation->company_id;
        $user->save();
        $user->syncRoles([$lockedInvitation->role]);

        $lockedInvitation->accepted_at = now();
        $lockedInvitation->save();
    });

    return redirect()
    ->route('dashboard.redirect')
    ->with('success', 'You have joined the company successfully.');
}


}
