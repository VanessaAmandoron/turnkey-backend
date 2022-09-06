<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_properties', function (Blueprint $table) {
            $table->id();
            $table->string('p_title');
            $table->string('price');
            $table->string('p_type');
            $table->string('area');
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->longText('p_info');
            $table->string('loc_a');
            $table->string('loc_b');
            $table->string('city');
            $table->string('z_code');
            $table->string('p_img');
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
        Schema::dropIfExists('add_properties');
    }
}
