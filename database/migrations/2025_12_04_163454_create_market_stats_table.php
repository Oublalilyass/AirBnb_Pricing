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
        Schema::create('market_stats', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->integer('month');
            $table->decimal('avg_price', 10, 2);
            $table->float('avg_occupancy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_stats');
    }
};
