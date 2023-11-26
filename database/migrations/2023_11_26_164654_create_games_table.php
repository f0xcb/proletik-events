<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time');
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('guest_team_id')->constrained('teams');
            $table->integer('home_team_points');
            $table->integer('guest_team_points');
            $table->string('league');
            $table->string('season');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
