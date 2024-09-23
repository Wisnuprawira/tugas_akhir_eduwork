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
        Schema::create('products', function (Blueprint $table) {
            $table->id('pd_id');
            $table->unsignedBigInteger('pd_code');
            $table->unsignedBigInteger('pd_ct_id');
            $table->string('pd_name');
            $table->char('pd_price');
            $table->timestamps();

            $table->foreign('pd_ct_id')->references('ct_id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
