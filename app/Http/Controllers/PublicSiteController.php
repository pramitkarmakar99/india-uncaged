<?php
namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\GalleryImage;
use App\Models\JournalArticle;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PublicSiteController extends Controller {
 public function home(): View {
  $upcoming=TourDate::query()->with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->whereNull('archived_at'))->orderBy('start_date')->get();
  $featured=TourDate::query()->with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->where('featured',true)->whereNull('archived_at'))->orderBy('start_date')->get();
  $featuredIds=$featured->pluck('id');
  $rest=$upcoming->reject(fn($d)=>$featuredIds->contains($d->id))->shuffle();
  $gallery=GalleryImage::where('published',true)->where('featured',true)->latest()->limit(8)->get();
  $destinations=Destination::where('published',true)->whereNull('archived_at')->where('featured',true)->orderBy('name')->limit(6)->get();
  $journal=JournalArticle::where('published',true)->orderByDesc('published_at')->limit(3)->get();
  return view('home',compact('featured','rest','gallery','destinations','journal'));
 }
 public function destinations(): View { return view('destinations.index',['destinations'=>Destination::where('published',true)->whereNull('archived_at')->withCount(['tours'=>fn($q)=>$q->where('published',true)->whereNull('archived_at')])->orderBy('state_region')->orderBy('name')->get()]); }
 public function destination(Destination $destination): View {
  abort_unless($destination->published && !$destination->archived_at, 404);
  $destination->load(['tours'=>fn($q)=>$q->where('published',true)->whereNull('archived_at')->with(['dates'=>fn($d)=>$d->where('published',true)->where('start_date','>=',today())->orderBy('start_date')])]);
  return view('destinations.show', compact('destination'));
 }
 public function gallery(Request $request): View {
  $query=GalleryImage::where('published',true)->orderByDesc('featured')->latest();
  if($request->filled('category')) $query->where('category',$request->query('category'));
  return view('gallery',['images'=>$query->get()]);
 }
 public function tours(Request $request): View {
  $query=TourDate::with(['tour.destination'])
   ->where('published',true)->where('start_date','>=',today())
   ->whereHas('tour',fn($q)=>$q->where('published',true)->whereNull('archived_at'));
  if($request->filled('destination')) $query->whereHas('tour',fn($q)=>$q->where('destination_id',$request->query('destination')));
  if($request->filled('month')) { $month=(int)$request->query('month'); $query->whereMonth('start_date',$month); }
  if($request->filled('wildlife')) $query->whereHas('tour.destination',fn($q)=>$q->whereJsonContains('wildlife',$request->query('wildlife')));
  if($request->filled('experience')) $query->whereHas('tour.destination',fn($q)=>$q->whereJsonContains('experiences',$request->query('experience')));
  match($request->query('sort','soonest')) {
   'price'=>$query->orderByRaw('COALESCE(price, 999999999) asc')->orderBy('start_date'),
   'destination'=>$query->join('tours as filter_tours','tour_dates.tour_id','=','filter_tours.id')->join('destinations as filter_destinations','filter_tours.destination_id','=','filter_destinations.id')->orderBy('filter_destinations.name')->orderBy('tour_dates.start_date'),
   default=>$query->orderBy('start_date'),
  };
  $dates=$query->get();
  $destinations=Destination::where('published',true)->whereNull('archived_at')->orderBy('name')->get();
  $wildlife=Destination::where('published',true)->whereNull('archived_at')->get()->pluck('wildlife')->flatten()->filter()->unique()->sort()->values();
  $experiences=Destination::where('published',true)->whereNull('archived_at')->get()->pluck('experiences')->flatten()->filter()->unique()->sort()->values();
  return view('tours.index',compact('dates','destinations','wildlife','experiences'));
 }
}