<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dealer_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('dealers')->cascadeOnDelete(); // dealer_id
            $table->foreignId('child_id')->constrained('users')->cascadeOnDelete();     // bde_id (user)
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['parent_id', 'child_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('dealer_mappings'); }
};
