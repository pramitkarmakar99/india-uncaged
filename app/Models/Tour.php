<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;
use Illuminate\\Database\\Eloquent\\Relations\\HasMany;
class Tour extends Model {
 protected $guarded=[];
 protected $casts=['featured'=>'boolean','published'=>'boolean'];
 public function destination(): BelongsTo { return $this->belongsTo(Destination::class); }
 public function images(): HasMany { return $this->hasMany(TourImage::class)->orderBy('sort_order'); }
 public function itineraryDays(): HasMany { return $this->hasMany(TourItineraryDay::class)->orderBy('day_number'); }
 public function dates(): HasMany { return $this->hasMany(TourDate::class)->orderBy('start_date'); }
 public function inclusions(): HasMany { return $this->hasMany(TourInclusion::class)->orderBy('sort_order'); }
 public function exclusions(): HasMany { return $this->hasMany(TourExclusion::class)->orderBy('sort_order'); }
}