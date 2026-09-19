<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\Relations\\HasMany;
class Destination extends Model {
 protected $guarded=[];
 protected $casts=['wildlife'=>'array','experiences'=>'array','featured'=>'boolean','published'=>'boolean'];
 public function tours(): HasMany { return $this->hasMany(Tour::class); }
 public function galleryImages(){ return $this->belongsToMany(GalleryImage::class,'destination_gallery_images')->withPivot('sort_order')->orderBy('pivot_sort_order'); }
}