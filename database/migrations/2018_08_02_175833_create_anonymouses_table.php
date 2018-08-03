<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnonymousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anonymouses', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->string('email')->nullable();
            $table->string('ethereum_address')->nullable();  
            $table->string('privacy');
            $table->string('type');
            $table->string('number');
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
        Schema::drop('anonymouses');
    }
}
