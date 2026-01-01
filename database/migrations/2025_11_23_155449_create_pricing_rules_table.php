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
    Schema::create('pricing_rules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('listing_id')->constrained()->onDelete('cascade');

        $table->enum('rule_type', [
            'season',
            'weekend',
            'event',
            'demand',
        ]);

        $table->string('name');
        $table->decimal('value', 10, 2); // allow decimals
        $table->enum('value_type', ['percentage', 'fixed']);

        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        $table->timestamps();

        // Index for faster filtering
        $table->index(['listing_id', 'start_date', 'end_date']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
