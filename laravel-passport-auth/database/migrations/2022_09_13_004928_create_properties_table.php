<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('p_title');
            $table->integer('price');
            $table->string('p_type');
            $table->integer('area');
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->longText('p_info');
            $table->string('loc_a');
            $table->string('loc_b');
            $table->string('city');
            $table->string('z_code');
            $table->binary('p_img');
            $table->timestamps();
            $table->foreignId('user_id')
                ->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void 
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
