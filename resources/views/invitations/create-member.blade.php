
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invite Team Member - URL Shortener</title>

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

        <span class="text-white">Team Management</span>
    </div>
</nav>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <h2 class="fw-bold mb-2">Invite New Team Member</h2>
            <p class="text-muted mb-4">
                Invite an Admin or Member to your company.
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
                            <label for="name" class="form-label">
                                User Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter user's name"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="user@example.com"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">
                                Role
                            </label>

                            <select
                                class="form-select"
                                id="role"
                                name="role"
                                required
                            >
                                <option value="Member"
                                    @selected(old('role', 'Member') === 'Member')>
                                    Member
                                </option>

                                <option value="Admin"
                                    @selected(old('role') === 'Admin')>
                                    Admin
                                </option>
                            </select>
                        </div>

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
