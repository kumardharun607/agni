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
        Schema::create('bde_home_locations', function (Blueprint $table) {

$table->id();

$table->string('bde_id');

$table->decimal('home_lat',10,7);

$table->decimal('home_long',10,7);

$table->text('home_address');

$table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bde_home_locations');
    }
};
