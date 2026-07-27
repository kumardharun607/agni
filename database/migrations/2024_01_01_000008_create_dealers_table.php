<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('alias_id')->unique();  // auto generated 001,002.. per client_type
            $table->string('name');
            $table->unsignedTinyInteger('client_type'); // 1 existing, 2 new, 3 sub
            $table->foreignId('parent_dealer_id')->nullable()->constrained('dealers')->nullOnDelete();
            $table->string('designation')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile', 15);
            $table->string('alternate_mobile', 15)->nullable();
            $table->string('whatsapp_number', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->decimal('credit_limit', 12, 2)->nullable();
            $table->string('payment_terms')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('pincode_id')->nullable()->constrained('pincodes');
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('dealers'); }
};
