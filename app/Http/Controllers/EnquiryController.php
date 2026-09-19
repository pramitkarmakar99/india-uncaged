<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Enquiry;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function create(Request $request): View
    {
        return view('plan', [
            'destinations' => Destination::where('published', true)->whereNull('archived_at')->orderBy('name')->get(),
            'prefillDestination' => $request->query('destination'),
            'prefillTour' => $request->query('tour'),
            'tour' => $request->filled('tour') ? Tour::where('slug', $request->query('tour'))->where('published', true)->first() : null,
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
            'interests' => ['nullable','array'],
            'interests.*' => ['string','max:100'],
            'message' => ['nullable','string','max:5000'],
            'tour_id' => ['nullable','exists:tours,id'],
            'tour_date_id' => ['nullable','exists:tour_dates,id'],
            'source' => ['nullable','in:contact,plan,tour'],
        ]);

        $data['source'] = $data['source'] ?? 'plan';
        Enquiry::create($data);

        return redirect()->route('plan')->with('success', 'Thank you. Your enquiry has been received. We will get in touch shortly.');
    }
}
