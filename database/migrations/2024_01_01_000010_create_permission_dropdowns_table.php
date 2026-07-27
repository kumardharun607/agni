<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permission_dropdowns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // module/feature name e.g Dealer, Mapping, Users...
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('permission_dropdowns'); }
};
