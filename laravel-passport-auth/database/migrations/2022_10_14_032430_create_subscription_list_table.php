<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id')->unsigned()->index();
            $table->foreign('agent_id')->references('id')->on('users');
            $table->bigInteger('subscription_id')->unsigned()->index();
            $table->foreign('subscription_id')->references('id')->on('subscription_infos');
            $table->string('subscription_type');
            // $table->foreign('subscription_type')->references('subscription_type')->on('subscription_infos');
            $table->string('first_name')->references('first_name')->on('users');
            $table->string('last_name')->references('last_name')->on('users');
            $table->string('hash')->nullable();
            $table->string('start_date');
            $table->string('expire_date');
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
        Schema::dropIfExists('subscription_list');
    }
}
