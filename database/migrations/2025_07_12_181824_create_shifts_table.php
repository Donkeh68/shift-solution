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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->string("employee", length: 150);
            $table->string("employer", length: 150);
            $table->tinyInteger("hours");
            $table->decimal("rate_per_hour", total: 8, places: 2);
            $table->enum("taxable", ["Yes", "No"]);
            $table->enum("status", ["Complete", "Failed", "Pending", "Processing"]);
            $table->enum("shift_type", ["Day", "Holiday", "Night"]);
            $table->dateTime("paid_at", precision: 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
