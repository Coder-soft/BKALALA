<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->integer('id');
            $table->text('home_ads_top')->nullable();
            $table->text('home_ads_bottom')->nullable();
            $table->text('mobile_ads')->nullable();
            $table->text('user_account_ads')->nullable();
            $table->text('download_top_ads')->nullable();
            $table->text('download_left_top_ads')->nullable();
            $table->text('download_left_bottom_ads')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
