<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->unique()->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_trailers');
    }
};
