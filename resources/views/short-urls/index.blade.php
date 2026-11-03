
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Short URLs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Short URLs</h2>

    <div class="d-flex gap-2">
        @hasanyrole('Admin|Member')
            <a href="{{ route('short-urls.create') }}" class="btn btn-primary">
                Create Short URL
            </a>
        @endhasanyrole

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                Logout
            </button>
        </form>
    </div>
</div>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('created_url'))
        <div class="alert alert-info">
            <strong>Your short URL:</strong>
            <a href="{{ session('created_url') }}" target="_blank" rel="noopener">
                {{ session('created_url') }}
            </a>

            <button
                type="button"
                class="btn btn-sm btn-outline-primary ms-2"
                onclick="navigator.clipboard.writeText(@js(session('created_url')))">
                Copy
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Short URL</th>
                        <th>Original URL</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shortUrls as $shortUrl)
                        <tr>
                            <td>
                                <a href="{{ url('/' . $shortUrl->code) }}" target="_blank" rel="noopener">
                                    {{ url('/' . $shortUrl->code) }}
                                </a>
                            </td>
                            <td class="text-break">{{ $shortUrl->original_url }}</td>
                            <td>{{ $shortUrl->user->name ?? 'Unknown' }}</td>
                            <td>{{ $shortUrl->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                No short URLs created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $shortUrls->links() }}
    </div>
</div>
</body>
</html>
