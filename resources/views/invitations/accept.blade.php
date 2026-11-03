
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accept Invitation - URL Shortener</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h2 class="fw-bold mb-3">Company Invitation</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if ($error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @elseif ($invitation)
                        <p>
                            You have been invited to join
                            <strong>{{ $invitation->company->name }}</strong>.
                        </p>

                        <p>
                            <strong>Email:</strong>
                            {{ $invitation->email }}
                        </p>

                        <p>
                            <strong>Role:</strong>
                            {{ $invitation->role }}
                        </p>

                        <p class="text-muted small">
                            This invitation expires
                            {{ $invitation->expires_at->format('d M Y, h:i A') }}.
                        </p>

                        @auth
                            @if (strtolower(auth()->user()->email) === strtolower($invitation->email))
                                <form
                                    method="POST"
                                    action="{{ route('invitations.accept.store', ['token' => request()->route('token')]) }}"
                                >
                                    @csrf

                                    <button type="submit" class="btn btn-primary">
                                        Accept Invitation
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    You are logged in with a different email address.
                                    Log in using {{ $invitation->email }} to accept this invitation.
                                </div>
                            @endif
                        @else
                            <p class="text-muted">
                                Log in or create an account using the invited email
                                address to continue.
                            </p>

                           <a
                                href="{{ route('login') }}?invitation={{ request()->route('token') }}"
                                class="btn btn-primary"
                            >
                                Log In
                            </a>

                          <a
                            href="{{ route('register') }}?invitation={{ request()->route('token') }}"
                            class="btn btn-outline-secondary ms-2"
                        >
                            Register
                        </a>
                        @endauth
                    @endif

                </div>
            </div>

        </div>
    </div>
</main>

</body>
</html>
