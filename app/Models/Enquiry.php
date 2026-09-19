<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Enquiry extends Model {
 public function tour(){ return $this->belongsTo(\App\Models\Tour::class); }
 public function tourDate(){ return $this->belongsTo(\App\Models\TourDate::class); }
 protected $guarded=[];
 protected $casts=['interests'=>'array'];
}