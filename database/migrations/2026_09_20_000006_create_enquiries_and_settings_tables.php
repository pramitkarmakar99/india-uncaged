<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('enquiries', function(Blueprint $table){ $table->id(); $table->string('source')->default('contact'); $table->string('name'); $table->string('email')->nullable(); $table->string('whatsapp')->nullable(); $table->string('destination')->nullable(); $table->string('preferred_dates')->nullable(); $table->unsignedInteger('travellers')->nullable(); $table->string('budget')->nullable(); $table->json('interests')->nullable(); $table->text('message')->nullable(); $table->foreignId('tour_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('tour_date_id')->nullable()->constrained()->nullOnDelete(); $table->enum('status',['new','contacted','quoted','confirmed','completed','closed'])->default('new'); $table->text('admin_notes')->nullable(); $table->timestamps(); });
  Schema::create('site_settings', function(Blueprint $table){ $table->id(); $table->string('key')->unique(); $table->text('value')->nullable(); $table->timestamps(); });
 }
 public function down(): void { Schema::dropIfExists('site_settings'); Schema::dropIfExists('enquiries'); }
};