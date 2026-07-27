<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('emp_code')->unique();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('name');
            $table->string('mobile', 15)->unique();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('pincode_id')->nullable()->constrained('pincodes');
            $table->text('address')->nullable();
            $table->date('doj')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->unique();
            $table->string('password');        // hashed password
            $table->string('plain_password');   // stored as plain text per spec (admin visibility)
            $table->string('otp', 6)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
