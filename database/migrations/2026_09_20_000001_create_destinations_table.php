<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('destinations', function(Blueprint $table){ $table->id(); $table->string('slug')->unique(); $table->string('name'); $table->string('state_region')->nullable(); $table->string('tagline')->nullable(); $table->text('about')->nullable(); $table->text('why_visit')->nullable(); $table->json('wildlife')->nullable(); $table->string('best_season')->nullable(); $table->text('best_season_description')->nullable(); $table->json('experiences')->nullable(); $table->string('hero_image')->nullable(); $table->boolean('featured')->default(false); $table->boolean('published')->default(false); $table->string('seo_title')->nullable(); $table->text('seo_description')->nullable(); $table->string('seo_image')->nullable(); $table->timestamp('archived_at')->nullable(); $table->timestamps(); }); }
 public function down(): void { Schema::dropIfExists('destinations'); }
};