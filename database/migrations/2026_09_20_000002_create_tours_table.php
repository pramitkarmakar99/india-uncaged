<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('tours', function(Blueprint $table){ $table->id(); $table->foreignId('destination_id')->constrained()->cascadeOnDelete(); $table->string('slug')->unique(); $table->string('name'); $table->string('short_description')->nullable(); $table->longText('description')->nullable(); $table->text('why_visit')->nullable(); $table->text('best_time')->nullable(); $table->decimal('base_price',12,2)->nullable(); $table->unsignedInteger('group_size')->nullable(); $table->unsignedInteger('safari_count')->nullable(); $table->string('hero_image')->nullable(); $table->boolean('featured')->default(false); $table->boolean('published')->default(false); $table->string('seo_title')->nullable(); $table->text('seo_description')->nullable(); $table->string('seo_image')->nullable(); $table->timestamp('archived_at')->nullable(); $table->timestamps(); }); }
 public function down(): void { Schema::dropIfExists('tours'); }
};