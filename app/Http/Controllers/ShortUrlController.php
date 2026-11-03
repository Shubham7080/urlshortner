<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ShortUrlController extends Controller
{
    /**
     * Display short URLs belonging to the user's company.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = ShortUrl::with(['user', 'company']);

        if ($user->hasRole('Member')) {
            $query->where('user_id', $user->id);
        } elseif ($user->hasRole('Admin')) {
            $query->where('company_id', $user->company_id);
        } else {
            abort(403, 'You are not allowed to access this page.');
        }

        $shortUrls = $query->latest()->paginate(10);

        return view('short-urls.index', compact('shortUrls'));
    }
    /**
     * Show the create form.
     */
    public function create()
    {
        return view('short-urls.create');
    }

    /**
     * Create a short URL.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->company_id) {
            throw ValidationException::withMessages([
                'url' => 'You must belong to a company before creating short URLs.',
            ]);
        }

        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
        ]);

        do {
            $code = Str::random(7);
        } while (ShortUrl::where('code', $code)->exists());

        $shortUrl = ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $validated['url'],
            'code' => $code,
        ]);

        return redirect()
            ->route('short-urls.index')
            ->with('success', 'Short URL created successfully.')
            ->with('created_url', url('/' . $shortUrl->code));
    }

    /**
     * Redirect a visitor to the original URL.
     */
    public function redirect(string $code)
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();

        return redirect()->away($shortUrl->original_url);
    }
}