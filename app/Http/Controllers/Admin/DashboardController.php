<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Enquiry;
use App\Models\GalleryImage;
use App\Models\JournalArticle;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'destinations' => Destination::where('published', true)->whereNull('archived_at')->count(),
                'tours' => Tour::where('published', true)->whereNull('archived_at')->count(),
                'departures' => TourDate::where('published', true)->where('start_date', '>=', today())->count(),
                'gallery' => GalleryImage::where('published', true)->count(),
                'journal' => JournalArticle::where('published', true)->count(),
                'enquiries' => Enquiry::where('status', 'new')->count(),
            ],
        ]);
    }
}
