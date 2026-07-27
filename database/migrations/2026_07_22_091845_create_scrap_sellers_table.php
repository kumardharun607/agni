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
      Schema::create('scrap_sellers', function (Blueprint $table) {

$table->id();

$table->string('alies_id')->nullable();

$table->string('company_name');

$table->string('business_age')->nullable();

$table->string('owner_name');

$table->string('mobile');

$table->string('owner_type')->nullable();

$table->text('address');

$table->string('gst_no')->nullable();

$table->string('pan_no')->nullable();

$table->string('email')->nullable();

$table->string('owner_rent')->nullable();

$table->string('godownspace')->nullable();

$table->string('company_seller1')->nullable();

$table->string('company_seller2')->nullable();

$table->string('company_seller3')->nullable();

$table->string('company_seller4')->nullable();

$table->string('company_seller5')->nullable();

$table->integer('tonmonth1')->default(0);

$table->integer('tonmonth2')->default(0);

$table->integer('tonmonth3')->default(0);

$table->integer('tonmonth4')->default(0);

$table->integer('tonmonth5')->default(0);

$table->integer('total_ton')->default(0);

$table->string('other_business')->nullable();

$table->string('agni_business_value')->nullable();

$table->text('question1')->nullable();

$table->text('question2')->nullable();

$table->text('question3')->nullable();

$table->text('question4')->nullable();

$table->text('question5')->nullable();

$table->text('question6')->nullable();

$table->text('question7')->nullable();

$table->text('question8')->nullable();

$table->string('shop_image')->nullable();

$table->string('godown_image')->nullable();

$table->string('pancard_image')->nullable();

$table->string('aadhar_front_image')->nullable();

$table->string('aadhar_back_image')->nullable();

$table->string('reg_certificate_image')->nullable();

$table->string('action')->nullable();

$table->date('cdate')->nullable();

$table->string('rep_id')->nullable();

$table->string('approval')->default('Pending');

$table->softDeletes();

$table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrap_sellers');
    }
};
