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
        Schema::table('contests', function (Blueprint $table) {
            //

            $table->dateTime('contest_start'); // Add contest start date and time
            $table->dateTime('contest_end'); // Add contest end date and time
            $table->dateTime('contest_display_start'); // Add contest display start date and time
            $table->dateTime('contest_display_end'); // Add contest display end date and time
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contests', function (Blueprint $table) {
            //

            $table->dateTime('contest_start'); // Add contest start date and time
            $table->dateTime('contest_end'); // Add contest end date and time
            $table->dateTime('contest_display_start'); // Add contest display start date and time
            $table->dateTime('contest_display_end'); // Add contest display end date and time
        });
    }
};
