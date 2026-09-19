<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('tour_dates', function(Blueprint $table){ $table->id(); $table->foreignId('tour_id')->constrained()->cascadeOnDelete(); $table->date('start_date'); $table->date('end_date'); $table->decimal('price',12,2)->nullable(); $table->unsignedInteger('total_seats')->nullable(); $table->unsignedInteger('available_seats')->nullable(); $table->enum('status',['upcoming','almost_full','full','cancelled','completed'])->default('upcoming'); $table->boolean('published')->default(false); $table->timestamps(); $table->index(['start_date','published']); }); }
 public function down(): void { Schema::dropIfExists('tour_dates'); }
};