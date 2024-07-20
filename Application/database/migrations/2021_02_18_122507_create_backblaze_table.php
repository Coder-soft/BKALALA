<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackblazeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backblaze', function (Blueprint $table) {
            $table->integer('id');
            $table->string('b2_bucket')->nullable();
            $table->string('b2_account_id')->nullable();
            $table->string('b2_application_key')->nullable();
            $table->string('b2_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backblaze');
    }
}
