<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('tour_images', function(Blueprint $t){ $t->id(); $t->foreignId('tour_id')->constrained()->cascadeOnDelete(); $t->string('image_path')->nullable(); $t->text('caption')->nullable(); $t->unsignedInteger('sort_order')->default(0); $t->timestamps(); });
  Schema::create('tour_itinerary_days', function(Blueprint $t){ $t->id(); $t->foreignId('tour_id')->constrained()->cascadeOnDelete(); $t->unsignedInteger('day_number'); $t->string('title')->nullable(); $t->longText('description')->nullable(); $t->timestamps(); });
  Schema::create('tour_inclusions', function(Blueprint $t){ $t->id(); $t->foreignId('tour_id')->constrained()->cascadeOnDelete(); $t->text('text'); $t->unsignedInteger('sort_order')->default(0); $t->timestamps(); });
  Schema::create('tour_exclusions', function(Blueprint $t){ $t->id(); $t->foreignId('tour_id')->constrained()->cascadeOnDelete(); $t->text('text'); $t->unsignedInteger('sort_order')->default(0); $t->timestamps(); });
 }
 public function down(): void { foreach(['tour_exclusions','tour_inclusions','tour_itinerary_days','tour_images'] as $t) Schema::dropIfExists($t); }
};