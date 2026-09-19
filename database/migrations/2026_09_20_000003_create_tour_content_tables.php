<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('tour_images', fn(Blueprint $t)=>$t->id()->foreignId('tour_id')->constrained()->cascadeOnDelete()->string('image_path')->nullable()->text('caption')->nullable()->unsignedInteger('sort_order')->default(0)->timestamps());
  Schema::create('tour_itinerary_days', fn(Blueprint $t)=>$t->id()->foreignId('tour_id')->constrained()->cascadeOnDelete()->unsignedInteger('day_number')->string('title')->nullable()->longText('description')->nullable()->timestamps());
  Schema::create('tour_inclusions', fn(Blueprint $t)=>$t->id()->foreignId('tour_id')->constrained()->cascadeOnDelete()->text('text')->unsignedInteger('sort_order')->default(0)->timestamps());
  Schema::create('tour_exclusions', fn(Blueprint $t)=>$t->id()->foreignId('tour_id')->constrained()->cascadeOnDelete()->text('text')->unsignedInteger('sort_order')->default(0)->timestamps());
 }
 public function down(): void { foreach(['tour_exclusions','tour_inclusions','tour_itinerary_days','tour_images'] as $t) Schema::dropIfExists($t); }
};