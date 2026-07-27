<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Column lengths below are deliberately tightened from Laravel's default
 * varchar(255) to realistic sizes for each field. With ~70 columns, using
 * the default 255 on every one blows past MySQL's 65,535-byte max row size
 * once utf8mb4 (4 bytes/char) is factored in — this migration keeps the
 * same columns/order/nullability, just with sane, deliberate lengths.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dealer_registrations', function (Blueprint $table) {
            $table->id();

            // Identification / application numbering
            $table->string('alias_id', 50)->nullable();
            $table->string('apply_id', 50)->nullable();
            $table->string('state_wise', 10)->nullable();
            $table->string('serial_no', 20)->nullable();
            $table->string('apply_no', 50)->nullable();

            // Shop basics
            $table->string('shop_est_yr', 10)->nullable();
            $table->string('age_of_bus', 50)->nullable();
            $table->string('own_rent', 20)->nullable();
            $table->string('agni_exp_ton', 50)->nullable();
            $table->string('dealer_total_capacity', 50)->nullable();
            $table->text('near_d')->nullable();

            // Approval / workflow
            $table->string('so_approved_name', 100)->nullable();
            $table->string('manager_name', 100)->nullable();
            $table->string('manager_status', 20)->nullable();
            $table->string('admin_status', 20)->default('Pending');

            // Images (storage disk paths — keep generous)
            $table->string('photo_upload1', 255)->nullable();
            $table->string('photo_upload2', 255)->nullable();

            // People / firm
            $table->string('n_of_propriter', 150)->nullable();
            $table->string('n_of_firm', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('alter_mobno1', 20)->nullable();
            $table->string('alter_mobno2', 20)->nullable();

            // Bank / firm status
            // type_of_ac / status_of_firm / other_business are rendered as
            // checkbox groups on the form and stored as comma-separated
            // values (e.g. "HARDWARE,ELECTRICAL,PAINTS"), so these are
            // deliberately wider than a single option would need.
            $table->string('name_add_bank', 150)->nullable();
            $table->string('type_of_ac', 40)->nullable();
            $table->string('status_of_firm', 100)->nullable();
            $table->string('other_business', 150)->nullable();

            // Turnover
            $table->string('total_turnover_month', 30)->nullable();
            $table->string('total_turnover_year', 30)->nullable();

            // Nearby Agni dealers
            $table->string('east', 150)->nullable();
            $table->string('e_dist', 20)->nullable();
            $table->string('west', 150)->nullable();
            $table->string('w_dist', 20)->nullable();
            $table->string('south', 150)->nullable();
            $table->string('s_dist', 20)->nullable();
            $table->string('north', 150)->nullable();
            $table->string('n_dist', 20)->nullable();

            // Steel brands dealt (1-6) + tonnage/month
            $table->string('shop_brand1', 100)->nullable();
            $table->string('shop_month_brand1', 20)->nullable();
            $table->string('shop_brand2', 100)->nullable();
            $table->string('shop_month_brand2', 20)->nullable();
            $table->string('shop_brand3', 100)->nullable();
            $table->string('shop_month_brand3', 20)->nullable();
            $table->string('shop_brand4', 100)->nullable();
            $table->string('shop_month_brand4', 20)->nullable();
            $table->string('shop_brand5', 100)->nullable();
            $table->string('shop_month_brand5', 20)->nullable();
            $table->string('shop_brand6', 100)->nullable();
            $table->string('shop_month_brand6', 20)->nullable();

            // Commercial
            $table->string('commercial_brand', 100)->nullable();
            $table->string('commercial_ton', 20)->nullable();

            // Cement brands (1-4) + tonnage/month
            $table->string('cement_brand1', 100)->nullable();
            $table->string('cement_month_cement1', 20)->nullable();
            $table->string('cement_brand2', 100)->nullable();
            $table->string('cement_month_cement2', 20)->nullable();
            $table->string('cement_brand3', 100)->nullable();
            $table->string('cement_month_cement3', 20)->nullable();
            $table->string('cement_brand4', 100)->nullable();
            $table->string('cement_month_cement4', 20)->nullable();

            // Nearby Agni Dealers - TON/MONTH per direction (east/west/south/north)
            $table->string('other1', 50)->nullable();
            $table->string('other2', 50)->nullable();
            $table->string('other3', 50)->nullable();
            $table->string('other4', 50)->nullable();

            // Dealer type for each nearby direction (sub_1..sub_4) + dealer classification
            $table->string('dealers_type', 30)->nullable();
            $table->string('sub_1', 30)->nullable();
            $table->string('sub_2', 30)->nullable();
            $table->string('sub_3', 30)->nullable();
            $table->string('sub_4', 30)->nullable();

            // Area
            $table->string('shop_areasq', 20)->nullable();
            $table->string('godown_areasq', 20)->nullable();

            // Workflow action note
            $table->string('action', 50)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dealer_registrations');
    }
};
