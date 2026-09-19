<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index(): View
    {
        return view('admin.tours.index', [
            'tours' => Tour::with('destination')->withCount('dates')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.tours.form', ['tour' => new Tour(), 'destinations' => Destination::whereNull('archived_at')->orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tour = new Tour();
        $this->save($request, $tour);
        return redirect()->route('admin.tours.edit', $tour)->with('success', 'Tour created.');
    }

    public function edit(Tour $tour): View
    {
        $tour->load(['itineraryDays','inclusions','exclusions','images']);
        return view('admin.tours.form', [
            'tour' => $tour,
            'destinations' => Destination::whereNull('archived_at')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Tour $tour): RedirectResponse
    {
        $this->save($request, $tour);
        return redirect()->route('admin.tours.edit', $tour)->with('success', 'Tour updated.');
    }

    public function archive(Tour $tour): RedirectResponse
    {
        $tour->update(['archived_at' => now(), 'published' => false]);
        return redirect()->route('admin.tours.index')->with('success', 'Tour archived.');
    }

    private function save(Request $request, Tour $tour): void
    {
        $data = $request->validate([
            'destination_id' => ['required', 'exists:destinations,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'why_visit' => ['nullable', 'string'],
            'best_time' => ['nullable', 'string'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'group_size' => ['nullable', 'integer', 'min:1'],
            'safari_count' => ['nullable', 'integer', 'min:0'],
            'hero_image' => ['nullable', 'string', 'max:2048'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'seo_image' => ['nullable', 'string', 'max:2048'],
            'featured' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'itinerary' => ['nullable', 'array'],
            'itinerary.*.title' => ['nullable', 'string', 'max:255'],
            'itinerary.*.description' => ['nullable', 'string'],
            'inclusions' => ['nullable', 'array'],
            'inclusions.*' => ['nullable', 'string', 'max:1000'],
            'exclusions' => ['nullable', 'array'],
            'exclusions.*' => ['nullable', 'string', 'max:1000'],
            'gallery' => ['nullable', 'array'],
            'gallery.*.image_path' => ['nullable', 'string', 'max:2048'],
            'gallery.*.caption' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($data['slug'] ?: $data['name']);
        if (Tour::where('slug',$slug)->whereKeyNot($tour->id ?? 0)->exists()) $slug .= '-' . Str::lower(Str::random(5));

        DB::transaction(function () use ($data, $request, $tour, $slug) {
            $tour->fill(collect($data)->except(['itinerary','inclusions','exclusions','gallery'])->all());
            $tour->slug = $slug;
            $tour->featured = $request->boolean('featured');
            $tour->published = $request->boolean('published');
            $tour->save();

            $tour->itineraryDays()->delete();
            foreach ($request->input('itinerary', []) as $i => $day) {
                if (blank($day['title'] ?? null) && blank($day['description'] ?? null)) continue;
                $tour->itineraryDays()->create(['day_number' => $i + 1, 'title' => $day['title'] ?? null, 'description' => $day['description'] ?? null]);
            }

            $tour->inclusions()->delete();
            foreach ($request->input('inclusions', []) as $i => $item) if (filled($item)) $tour->inclusions()->create(['text'=>$item,'sort_order'=>$i]);

            $tour->exclusions()->delete();
            foreach ($request->input('exclusions', []) as $i => $item) if (filled($item)) $tour->exclusions()->create(['text'=>$item,'sort_order'=>$i]);

            $tour->images()->delete();
            foreach ($request->input('gallery', []) as $i => $image) if (filled($image['image_path'] ?? null)) $tour->images()->create(['image_path'=>$image['image_path'],'caption'=>$image['caption'] ?? null,'sort_order'=>$i]);
        });
    }
}
