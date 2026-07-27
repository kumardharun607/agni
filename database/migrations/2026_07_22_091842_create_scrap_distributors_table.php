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
        Schema::create('scrap_distributors', function (Blueprint $table) {

            $table->id();

            $table->string('rep_id')->nullable();

            $table->string('name');

            $table->string('customer_name');

            $table->string('mobile',20);

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('state_id')
                ->constrained('states')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('city_id')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('pincode_id')
                ->constrained('pincodes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('address');

            $table->string('gst_no')->nullable();

            $table->string('pan_no')->nullable();

            $table->string('email')->nullable();

            $table->decimal('latitude',10,7)->nullable();

            $table->decimal('longitude',10,7)->nullable();

            $table->date('dob')->nullable();

            $table->date('date')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrap_distributors');
    }
};