<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse;

class RegistrationResponse implements RegisterResponse
{
    public function toResponse($request)
    {
        $token = $request->session()->pull('invitation_token');

        if ($token) {
            return redirect()->route('invitations.accept', [
                'token' => $token,
            ]);
        }

        return redirect()->intended(config('fortify.home'));
    }
}