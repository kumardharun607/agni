<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users')->cascadeOnDelete(); // higher level user
            $table->foreignId('child_id')->constrained('users')->cascadeOnDelete();  // lower level user
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['parent_id', 'child_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('user_mappings'); }
};
