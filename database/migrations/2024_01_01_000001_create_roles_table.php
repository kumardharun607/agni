<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Telecaller, Manager, SO, BDE, Admin
            $table->unsignedTinyInteger('level')->nullable(); // 1 Telecaller,2 Manager,3 SO,4 BDE
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('roles'); }
};
