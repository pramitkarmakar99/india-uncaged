<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;
class TourDate extends Model {
 protected $guarded=[];
 protected $casts=['start_date'=>'date','end_date'=>'date','published'=>'boolean'];
 public function tour(): BelongsTo { return $this->belongsTo(Tour::class); }
}