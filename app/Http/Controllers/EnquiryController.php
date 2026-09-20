<?php

namespace App\\Http\\Controllers;

use App\\Models\\Destination;
use App\\Models\\Enquiry;
use App\\Models\\Tour;
use Illuminate\\Http\\RedirectResponse;
use Illuminate\\Http\\Request;
use Illuminate\\View\\View;
use Illuminate\\Validation\\Rule;

class EnquiryController extends Controller
{
    public function create(Request $request): View
    {
        $tour = $request->filled('tour')
            ? Tour::where('slug', $request->query('tour'))
                ->where('published', true)
                ->whereNull('archived_at')
                ->whereHas('destination', fn ($q) => $q->where('published', true)->whereNull('archived_at'))
                ->first()
            : null;

        return view('plan', [
            'destinations' => Destination::where('published', true)->whereNull('archived_at')->orderBy('name')->get(),
            'prefillDestination' => $request->query('destination'),
            'prefillTour' => $request->query('tour'),
            'tour' => $tour,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'whatsapp' => ['required','string','max:30'],
            'email' => ['nullable','email','max:255'],
            'destination' => ['nullable','string','max:255'],
            'preferred_dates' => ['nullable','string','max:255'],
            'travellers' => ['nullable','integer','min:1','max:100'],
            'budget' => ['nullable','string','max:255'],
            'interests' => ['nullable','array','max:10'],
            'interests.*' => ['string','max:100'],
            'message' => ['nullable','string','max:5000'],
            'tour_id' => [
                'nullable',
                Rule::exists('tours', 'id')->where(fn ($q) => $q->where('published', true)->whereNull('archived_at')),
            ],
            'tour_date_id' => [
                'nullable',
                Rule::exists('tour_dates', 'id')->where(fn ($q) => $q->where('published', true)->where('start_date', '>=', now()->toDateString())),
            ],
            'source' => ['nullable','in:contact,plan,tour'],
        ]);

        if (! empty($data['tour_date_id']) && ! empty($data['tour_id'])) {
            $validDate = \App\\Models\\TourDate::whereKey($data['tour_date_id'])
                ->where('tour_id', $data['tour_id'])
                ->exists();

            if (! $validDate) {
                return back()->withErrors(['tour_date_id' => 'The selected departure is not valid for this tour.'])->withInput();
            }
        }

        $data['source'] = $data['source'] ?? 'plan';
        Enquiry::create($data);

        $redirect = $data['source'] === 'contact' ? 'contact' : 'plan';
        return redirect()->route($redirect)->with('success', 'Thank you. Your enquiry has been received. We will get in touch shortly.');
    }
}
