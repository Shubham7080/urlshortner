
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Short URL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h2 class="mb-4">Create Short URL</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('short-urls.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="url" class="form-label">Original URL</label>
                    <input
                        type="url"
                        id="url"
                        name="url"
                        class="form-control"
                        placeholder="https://example.com"
                        value="{{ old('url') }}"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Create Short URL
                </button>

                <a href="{{ route('short-urls.index') }}" class="btn btn-secondary">
                    View URLs
                </a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
