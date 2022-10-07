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
            $table->foreignIdFor(User::class)->constrained();
            $table->integer('agent_id');
            //$table->integer('property_id');
            $table->foreignIdFor(Property::class)->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number');
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
        Schema::dropIfExists('send_contact_details');
    }
}
