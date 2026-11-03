
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Companies - URL Shortener</title>

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

            <a
                href="{{ route('companies.create') }}"
                class="btn btn-primary btn-sm"
            >
                + Create Company
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-5">

        <div class="d-flex flex-column flex-md-row
                    justify-content-between align-items-md-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Companies</h2>
                <p class="text-muted mb-0">
                    View and manage registered companies.
                </p>
            </div>

            <a
                href="{{ route('companies.create') }}"
                class="btn btn-primary mt-3 mt-md-0"
            >
                + Create Company
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        <!-- Companies Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Company List</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Company Name</th>
                                <th>Slug</th>
                                <th>Created At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($companies as $company)
                                <tr>
                                    <td class="ps-4">
                                        {{ $companies->firstItem() + $loop->index }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $company->name }}
                                    </td>

                                    <td>
                                        <span class="badge text-bg-secondary">
                                            {{ $company->slug }}
                                        </span>
                                    </td>

                                    <td class="text-muted">
                                        {{ $company->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <h6 class="text-muted">
                                            No companies found
                                        </h6>

                                        <p class="text-muted mb-3">
                                            Create your first company to get started.
                                        </p>

                                        <a
                                            href="{{ route('companies.create') }}"
                                            class="btn btn-primary btn-sm"
                                        >
                                            Create Company
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($companies->hasPages())
                <div class="card-footer bg-white">
                    {{ $companies->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
