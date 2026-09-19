<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class GalleryImage extends Model {
 public function destination(){ return $this->belongsTo(\App\Models\Destination::class); }
 public function tour(){ return $this->belongsTo(\App\Models\Tour::class); }
 protected $guarded=[];
 protected $casts=['taken_on'=>'date','featured'=>'boolean','published'=>'boolean'];
}