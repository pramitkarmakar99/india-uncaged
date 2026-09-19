<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class GalleryImage extends Model {
 protected $guarded=[];
 protected $casts=['taken_on'=>'date','featured'=>'boolean','published'=>'boolean'];
}