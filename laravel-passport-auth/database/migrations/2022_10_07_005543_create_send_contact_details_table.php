<?php

use App\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;


class CreateSendContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_contact_details', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('users');
            $table->bigInteger('agent_id')->unsigned()->index();
            $table->foreign('agent_id')->references('user_id')->on('properties');
            $table->string('property_title')->unique();
            $table->foreignIdFor(Property::class)->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_contact_details');
    }
}
