<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHSNsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_s_ns', function (Blueprint $table) {
            $table->increments('id');
			$table->string('user_id')->nullable();
			$table->string('type')->nullable();
			$table->string('first_name')->nullable();
			$table->string('username')->nullable();
			$table->date('last_online')->nullable();
			$table->string('access_hash')->nullable();
			$table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('h_s_ns');
    }
}
