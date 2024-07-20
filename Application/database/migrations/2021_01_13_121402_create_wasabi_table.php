<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasabiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wasabi', function (Blueprint $table) {
            $table->integer('id');
            $table->string('wasabi_access_key_id')->nullable();
            $table->string('wasabi_secret_access_key')->nullable();
            $table->string('wasabi_default_region')->nullable();
            $table->string('wasabi_bucket')->nullable();
            $table->string('wasabi_root')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wasabi');
    }
}
