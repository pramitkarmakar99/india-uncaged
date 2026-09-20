<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(): View
    {
        return view('admin.destinations.index', [
            'destinations' => Destination::withCount('tours')->orderBy('state_region')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.destinations.form', [
            'destination' => new Destination(),
            'galleryImages' => \App\Models\GalleryImage::where('published', true)->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $destination = new Destination();
        $this->save($request, $destination);

        return redirect()->route('admin.destinations.edit', $destination)->with('success', 'Destination created.');
    }

    public function edit(Destination $destination): View
    {
        return view('admin.destinations.form', [
            'destination' => $destination->load('galleryImages'),
            'galleryImages' => \App\Models\GalleryImage::where('published', true)->latest()->get(),
        ]);
    }

    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $this->save($request, $destination);

        return redirect()->route('admin.destinations.edit', $destination)->with('success', 'Destination updated.');
    }

    public function archive(Destination $destination): RedirectResponse
    {
        $destination->update(['archived_at' => now(), 'published' => false]);
        return redirect()->route('admin.destinations.index')->with('success', 'Destination archived.');
    }

    private function save(Request $request, Destination $destination): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'state_region' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'why_visit' => ['nullable', 'string'],
            'wildlife' => ['nullable', 'string'],
            'best_season' => ['nullable', 'string', 'max:255'],
            'best_season_description' => ['nullable', 'string'],
            'experiences' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string', 'max:2048', 'regex:/^(https?:\/\/|\/storage\/)[^\s]+$/i'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'seo_image' => ['nullable', 'string', 'max:2048', 'regex:/^(https?:\/\/|\/storage\/)[^\s]+$/i'],
            'featured' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'gallery_ids' => ['nullable', 'array'],
            'gallery_ids.*' => ['integer', Rule::exists('gallery_images', 'id')->where('published', true)],
        ]);

        $slug = Str::slug($data['slug'] ?: $data['name']);
        $query = Destination::where('slug', $slug)->whereKeyNot($destination->id ?? 0);
        if ($query->exists()) {
            $slug .= '-' . Str::lower(Str::random(5));
        }

        $data['slug'] = $slug;
        $data['wildlife'] = $this->linesToArray($data['wildlife'] ?? null);
        $data['experiences'] = $this->linesToArray($data['experiences'] ?? null);
        $data['featured'] = $request->boolean('featured');
        $data['published'] = $request->boolean('published');
        $galleryIds = $data['gallery_ids'] ?? [];
        unset($data['gallery_ids']);

        $destination->fill($data)->save();
        $destination->galleryImages()->sync(array_values(array_unique($galleryIds)));
    }

    private function linesToArray(?string $value): array
    {
        if (! $value) return [];
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }
}
