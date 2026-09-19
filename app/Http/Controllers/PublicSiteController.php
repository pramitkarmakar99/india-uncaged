<?php
namespace App\\Http\\Controllers;
use App\\Models\\Destination;
use App\\Models\\Tour;
use App\\Models\\TourDate;
use Illuminate\\View\\View;
class PublicSiteController extends Controller {
 public function home(): View {
  $upcoming=TourDate::query()->with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->whereNull('archived_at'))->orderBy('start_date')->get();
  $featured=TourDate::query()->with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->where('featured',true)->whereNull('archived_at'))->orderBy('start_date')->get();
  $featuredIds=$featured->pluck('id');
  $rest=$upcoming->reject(fn($d)=>$featuredIds->contains($d->id))->shuffle();
  return view('home',compact('featured','rest'));
 }
 public function destinations(): View { return view('destinations.index',['destinations'=>Destination::where('published',true)->whereNull('archived_at')->orderBy('state_region')->orderBy('name')->get()]); }
 public function tours(): View { return view('tours.index',['dates'=>TourDate::with(['tour.destination'])->where('published',true)->where('start_date','>=',today())->whereHas('tour',fn($q)=>$q->where('published',true)->whereNull('archived_at'))->orderBy('start_date')->get()]); }
}