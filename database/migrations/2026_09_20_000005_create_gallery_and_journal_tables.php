<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('gallery_images', function(Blueprint $table){ $table->id(); $table->string('image_path'); $table->enum('category',['tour_experiences','bts','fauna','herping','birds','landscapes']); $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('tour_id')->nullable()->constrained()->nullOnDelete(); $table->text('caption')->nullable(); $table->string('location')->nullable(); $table->date('taken_on')->nullable(); $table->string('photographer')->nullable(); $table->boolean('featured')->default(false); $table->boolean('published')->default(false); $table->unsignedInteger('width')->nullable(); $table->unsignedInteger('height')->nullable(); $table->timestamps(); });
  Schema::create('destination_gallery_images', function(Blueprint $table){ $table->id(); $table->foreignId('destination_id')->constrained()->cascadeOnDelete(); $table->foreignId('gallery_image_id')->constrained()->cascadeOnDelete(); $table->unsignedInteger('sort_order')->default(0); $table->unique(['destination_id','gallery_image_id']); });
  Schema::create('journal_articles', function(Blueprint $table){ $table->id(); $table->string('slug')->unique(); $table->string('title'); $table->string('category')->nullable(); $table->text('excerpt')->nullable(); $table->string('cover_image')->nullable(); $table->string('author')->nullable(); $table->json('content')->nullable(); $table->boolean('published')->default(false); $table->timestamp('published_at')->nullable(); $table->string('seo_title')->nullable(); $table->text('seo_description')->nullable(); $table->string('seo_image')->nullable(); $table->timestamps(); });
 }
 public function down(): void { Schema::dropIfExists('journal_articles'); Schema::dropIfExists('destination_gallery_images'); Schema::dropIfExists('gallery_images'); }
};