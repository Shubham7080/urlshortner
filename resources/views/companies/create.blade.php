
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Company - URL Shortener</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                URL Shortener
            </a>

            <a href="{{ route('companies.index') }}"
               class="btn btn-outline-light btn-sm">
                View Companies
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="mb-4">
                    <h2 class="fw-bold">Create Company</h2>
                    <p class="text-muted">
                        Add a new company to your URL Shortener application.
                    </p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Please fix the following errors:</strong>

                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Company Form -->
                        <form
                            method="POST"
                            action="{{ route('companies.store') }}"
                        >
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    Company Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Acme Travel"
                                    maxlength="255"
                                    required
                                    autofocus
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text">
                                    Enter the name of the company you want to register.
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a
                                    href="{{ route('companies.index') }}"
                                    class="btn btn-outline-secondary"
                                >
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    Create Company
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
