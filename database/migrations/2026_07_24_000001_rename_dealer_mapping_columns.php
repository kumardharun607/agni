<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('dealer_mappings', function (Blueprint $table) {
            $table->renameColumn('parent_id', 'dealer_id');
            $table->renameColumn('child_id', 'bde_id');
        });
    }
    public function down(): void {
        Schema::table('dealer_mappings', function (Blueprint $table) {
            $table->renameColumn('dealer_id', 'parent_id');
            $table->renameColumn('bde_id', 'child_id');
        });
    }
};
