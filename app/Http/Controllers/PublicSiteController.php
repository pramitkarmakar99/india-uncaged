<?php
namespace App\\Http\\Controllers;
use App\\Models\\Destination;
use App\\Models\\Tour;
use App\\Models\\TourDate;
use App\\Models\\GalleryImage;
use Illuminate\\View\\View;
use Illuminate\\Http\\Request;
class PublicSiteController extends Controller {
 public function home(): View {
  $upcoming=TourDate::query()->with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->whereNull('archived_at'))->orderBy('start_date')->get();
  $featured=TourDate::query()->with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->where('featured',true)->whereNull('archived_at'))->orderBy('start_date')->get();
  $featuredIds=$featured->pluck('id');
  $rest=$upcoming->reject(fn($d)=>$featuredIds->contains($d->id))->shuffle();
  return view('home',compact('featured','rest'));
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
 public function tours(): View { return view('tours.index',['dates'=>TourDate::with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->whereNull('archived_at'))->orderBy('start_date')->get()]); }
 public function tour(Tour $tour): View {
  abort_unless($tour->published && !$tour->archived_at && $tour->destination?->published && !$tour->destination?->archived_at, 404);
  $tour->load(['destination','images','itineraryDays','inclusions','exclusions','dates'=>fn($q)=>$q->where('published',true)->where('start_date','>=',today())->orderBy('start_date')]);
  return view('tours.show', compact('tour'));
 }
}