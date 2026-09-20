<?php

namespace App\\Http\\Controllers;

use App\\Models\\Destination;
use App\\Models\\Tour;
use App\\Models\\TourDate;
use App\\Models\\GalleryImage;
use App\\Models\\JournalArticle;
use Illuminate\\View\\View;
use Illuminate\\Http\\Request;
use Illuminate\\Http\\Response;
use Illuminate\\Support\\Facades\\URL;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        $upcoming = TourDate::query()
            ->with(['tour.destination'])
            ->where('published', true)
            ->where('start_date', '>=', today())
            ->where('status', '!=', 'completed')
            ->whereHas('tour', fn ($q) => $q
                ->where('published', true)
                ->whereNull('archived_at')
                ->whereHas('destination', fn ($d) => $d->where('published', true)->whereNull('archived_at')))
            ->orderBy('start_date')
            ->get();

        $featured = TourDate::query()
            ->with(['tour.destination'])
            ->where('published', true)
            ->where('start_date', '>=', today())
            ->where('status', '!=', 'completed')
            ->whereHas('tour', fn ($q) => $q
                ->where('published', true)
                ->where('featured', true)
                ->whereNull('archived_at')
                ->whereHas('destination', fn ($d) => $d->where('published', true)->whereNull('archived_at')))
            ->orderBy('start_date')
            ->get();

        $featuredIds = $featured->pluck('id');
        $rest = $upcoming->reject(fn ($d) => $featuredIds->contains($d->id))->shuffle();

        $gallery = GalleryImage::where('published', true)->where('featured', true)->latest()->limit(8)->get();
        $destinations = Destination::where('published', true)->whereNull('archived_at')->where('featured', true)->orderBy('name')->limit(6)->get();
        $journal = JournalArticle::where('published', true)->where('published_at', '<=', now())->orderByDesc('published_at')->limit(3)->get();

        return view('home', compact('featured','rest','gallery','destinations','journal'));
    }

    public function sitemap(): Response
    {
        $urls = [
            ['loc'=>URL::to('/'),'lastmod'=>now()],
            ['loc'=>URL::to('/destinations'),'lastmod'=>now()],
            ['loc'=>URL::to('/tours'),'lastmod'=>now()],
            ['loc'=>URL::to('/gallery'),'lastmod'=>now()],
            ['loc'=>URL::to('/journal'),'lastmod'=>now()],
            ['loc'=>URL::to('/about'),'lastmod'=>now()],
            ['loc'=>URL::to('/contact'),'lastmod'=>now()],
            ['loc'=>URL::to('/plan-your-journey'),'lastmod'=>now()],
        ];

        foreach (Destination::where('published',true)->whereNull('archived_at')->get() as $item) {
            $urls[]=['loc'=>route('destinations.show',$item),'lastmod'=>$item->updated_at];
        }

        foreach (Tour::where('published',true)->whereNull('archived_at')
            ->whereHas('destination',fn($q)=>$q->where('published',true)->whereNull('archived_at'))
            ->get() as $item) {
            $urls[]=['loc'=>route('tours.show',$item),'lastmod'=>$item->updated_at];
        }

        foreach (JournalArticle::where('published',true)->where('published_at','<=',now())->get() as $item) {
            $urls[]=['loc'=>route('journal.show',$item),'lastmod'=>$item->updated_at];
        }

        return response()->view('sitemap',compact('urls'))->header('Content-Type','application/xml');
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nSitemap: ".URL::to('/sitemap.xml')."\n",200,['Content-Type'=>'text/plain']);
    }

    public function destinations(): View
    {
        return view('destinations.index',[
            'destinations'=>Destination::where('published',true)
                ->whereNull('archived_at')
                ->withCount(['tours'=>fn($q)=>$q->where('published',true)->whereNull('archived_at')])
                ->orderBy('state_region')->orderBy('name')->get()
        ]);
    }

    public function destination(Destination $destination): View
    {
        abort_unless($destination->published && !$destination->archived_at,404);

        $destination->load([
            'tours'=>fn($q)=>$q->where('published',true)->whereNull('archived_at')
                ->with(['dates'=>fn($d)=>$d->where('published',true)->where('start_date','>=',today())->where('status','!=','completed')->orderBy('start_date')]),
            'galleryImages'=>fn($q)=>$q->where('published',true)->orderBy('featured','desc')
        ]);

        return view('destinations.show', compact('destination'));
    }

    public function tours(Request $request): View
    {
        $query = TourDate::with(['tour.destination'])
            ->where('published',true)
            ->where('start_date','>=',today())
            ->where('status','!=','completed')
            ->whereHas('tour',fn($q)=>$q
                ->where('published',true)
                ->whereNull('archived_at')
                ->whereHas('destination',fn($d)=>$d->where('published',true)->whereNull('archived_at')));

        if($request->filled('destination')) $query->whereHas('tour',fn($q)=>$q->where('destination_id',$request->query('destination')));
        if($request->filled('month')) {
            $month=(int)$request->query('month');
            if($month>=1 && $month<=12) $query->whereMonth('start_date',$month);
        }
        if($request->filled('wildlife')) $query->whereHas('tour.destination',fn($q)=>$q->whereJsonContains('wildlife',$request->query('wildlife')));
        if($request->filled('experience')) $query->whereHas('tour.destination',fn($q)=>$q->whereJsonContains('experiences',$request->query('experience')));

        match($request->query('sort','soonest')) {
            'price'=>$query->orderByRaw('COALESCE(tour_dates.price, 999999999) asc')->orderBy('start_date'),
            'destination'=>$query->join('tours as filter_tours','tour_dates.tour_id','=','filter_tours.id')->join('destinations as filter_destinations','filter_tours.destination_id','=','filter_destinations.id')->select('tour_dates.*')->orderBy('filter_destinations.name')->orderBy('tour_dates.start_date'),
            default=>$query->orderBy('start_date'),
        };

        $dates=$query->get();
        $destinations=Destination::where('published',true)->whereNull('archived_at')->orderBy('name')->get();
        $wildlife=Destination::where('published',true)->whereNull('archived_at')->get()->pluck('wildlife')->flatten()->filter()->unique()->sort()->values();
        $experiences=Destination::where('published',true)->whereNull('archived_at')->get()->pluck('experiences')->flatten()->filter()->unique()->sort()->values();

        return view('tours.index',compact('dates','destinations','wildlife','experiences'));
    }

    public function tour(Tour $tour): View
    {
        abort_unless($tour->published && !$tour->archived_at,404);

        $tour->load([
            'destination',
            'images',
            'itineraryDays',
            'inclusions',
            'exclusions',
            'dates'=>fn($q)=>$q->where('published',true)->where('start_date','>=',today())->where('status','!=','completed')->orderBy('start_date')
        ]);

        abort_unless($tour->destination && $tour->destination->published && !$tour->destination->archived_at,404);

        return view('tours.show',compact('tour'));
    }

    public function gallery(Request $request): View
    {
        $query=GalleryImage::where('published',true)->orderByDesc('featured')->latest();
        if($request->filled('category')) $query->where('category',$request->query('category'));
        return view('gallery',['images'=>$query->get()]);
    }
}
