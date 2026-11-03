
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener Dashboard</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
<a class="navbar-brand" href="{{ route('dashboard') }}">
        <div class="d-flex align-items-center gap-3">
            <span class="text-white">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3">Dashboard</h1>
        <p class="text-muted">
            Manage your short URLs and company invitations.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Short URLs</h5>
                    <p class="card-text text-muted">
                        View and manage your short links.
                    </p>
                    <a href="{{ route('short-urls.index') }}"
                       class="btn btn-primary">
                        View URLs
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Create Short URL</h5>
                    <p class="card-text text-muted">
                        Turn a long URL into a short link.
                    </p>
                    <a href="{{ route('short-urls.create') }}"
                       class="btn btn-success">
                        Create URL
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Invitations</h5>
                    <p class="card-text text-muted">
                        Invite users to a company.
                    </p>
                    <a href="{{ route('invitations.create') }}"
                       class="btn btn-outline-primary">
                        Invite User
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
