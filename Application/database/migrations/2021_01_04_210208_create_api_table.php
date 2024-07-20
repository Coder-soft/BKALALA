<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api', function (Blueprint $table) {
            $table->integer('id');
            $table->text('google_key')->nullable();
            $table->text('google_secret')->nullable();
            $table->text('facebook_clientid')->nullable();
            $table->text('facebook_clientsecret')->nullable();
            $table->text('facebook_reurl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api');
    }
}
