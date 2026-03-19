<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('draft_plan_preferred_picks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draft_plan_id')->constrained('draft_plans')->cascadeOnDelete();
            $table->foreignId('hero_id')->constrained('heroes')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('draft_plan_preferred_picks');
    }
};
