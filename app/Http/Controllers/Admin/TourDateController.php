<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourDateController extends Controller
{
    public function index(): View
    {
        return view('admin.tour-dates.index', [
            'dates' => TourDate::with('tour.destination')->orderBy('start_date')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.tour-dates.form', [
            'tourDate' => new TourDate(['status' => 'upcoming', 'published' => false]),
            'tours' => Tour::whereNull('archived_at')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $date = new TourDate();
        $this->save($request, $date);
        return redirect()->route('admin.tour-dates.edit', $date)->with('success', 'Departure created.');
    }

    public function edit(TourDate $tourDate): View
    {
        return view('admin.tour-dates.form', [
            'tourDate' => $tourDate,
            'tours' => Tour::whereNull('archived_at')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, TourDate $tourDate): RedirectResponse
    {
        $this->save($request, $tourDate);
        return redirect()->route('admin.tour-dates.edit', $tourDate)->with('success', 'Departure updated.');
    }

    public function destroy(TourDate $tourDate): RedirectResponse
    {
        $tourDate->delete();
        return redirect()->route('admin.tour-dates.index')->with('success', 'Departure deleted.');
    }

    private function save(Request $request, TourDate $tourDate): void
    {
        $data = $request->validate([
            'tour_id' => ['required', 'exists:tours,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'total_seats' => ['nullable', 'integer', 'min:1'],
            'available_seats' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:upcoming,almost_full,full,cancelled,completed'],
            'published' => ['nullable', 'boolean'],
        ]);

        $tour = Tour::with('destination')->whereKey($data['tour_id'])->whereNull('archived_at')->first();
        abort_unless($tour, 422, 'The selected tour is archived or invalid.');
        if ($request->boolean('published') && (! $tour->published || ! $tour->destination?->published)) {
            abort(422, 'A departure cannot be published while its tour and destination are unpublished.');
        }

        if (($data['total_seats'] ?? null) !== null && ($data['available_seats'] ?? 0) > $data['total_seats']) {
            abort(422, 'Available seats cannot exceed total seats.');
        }

        $data['published'] = $request->boolean('published');
        $tourDate->fill($data)->save();
    }
}
