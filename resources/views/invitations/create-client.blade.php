
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invite New Client - URL Shortener</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            URL Shortener
        </a>

        <a href="{{ route('companies.index') }}"
           class="btn btn-outline-light btn-sm">
            Companies
        </a>
    </div>
</nav>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <h2 class="fw-bold mb-2">Invite New Client</h2>
            <p class="text-muted mb-4">
                Invite a client to join the URL Shortener service.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('invitations.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="company_name" class="form-label">
                                Client Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="company_name"
                                name="company_name"
                                value="{{ old('company_name') }}"
                                placeholder="e.g. Acme Travel"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="client@example.com"
                                required
                            >
                        </div>

                        <input type="hidden" name="role" value="Admin">

                        <button type="submit" class="btn btn-primary">
                            Send Invitation
                        </button>

                        <a href="{{ route('dashboard') }}"
                           class="btn btn-outline-secondary ms-2">
                            Cancel
                        </a>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success mt-3 mb-0">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('invitation_url'))
                        <div class="mt-3">
                            <label class="form-label fw-semibold">
                                Invitation Link
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ session('invitation_url') }}"
                                readonly
                                onclick="this.select()"
                            >
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
