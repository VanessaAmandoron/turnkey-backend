<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->double('price');
            $table->timestamps();
            $table->softDeletes();
            // $table->increments('id');
            // $table->bigInteger('agent_id')->unsigned()->index();
            // $table->foreign('agent_id')->references('id')->on('users');
            // $table->string('subscription_type')->unsigned()->index();
            // $table->foreign('subscription_type')->references('title')->on('subscription_infos');
            // $table->string('first_name')->references('first_name')->on('users');
            // $table->string('last_name')->references('last_name')->on('users');
            // $table->string('hash');
            // $table->string('start_date');
            // $table->string('expire_date');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_infos');
    }
}
