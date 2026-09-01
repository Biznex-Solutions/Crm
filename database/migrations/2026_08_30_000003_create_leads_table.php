<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lead_source_id')->constrained('lead_sources')->onDelete('cascade');
            $table->foreignId('category_target_id')->constrained('category_targets')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->enum('status', ['new', 'contacted', 'in_progress', 'won', 'lost'])->default('new');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
