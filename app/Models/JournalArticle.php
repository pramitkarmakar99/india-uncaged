<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class JournalArticle extends Model {
 protected $guarded=[];
 protected $casts=['content'=>'array','published'=>'boolean','published_at'=>'datetime'];
}