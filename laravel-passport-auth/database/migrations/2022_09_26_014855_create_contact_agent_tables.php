<?php

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactAgentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_agents', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(User::class)->constrained(); //user_id
            $table->foreignIdFor(Property::class); //user_id
            $table->integer('agent_id');
            $table->string('name');
            $table->string('property');
            $table->string('email'); 
            $table->text('phone_number');
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
        Schema::dropIfExists('contact_agent_tables');
    }
}
