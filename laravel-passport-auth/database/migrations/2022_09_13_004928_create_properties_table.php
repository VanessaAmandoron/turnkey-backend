<?php

use App\Models\User;
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
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('title');
            $table->decimal('price', 13, 2); 
            $table->unsignedTinyInteger('type');
            $table->unsignedinteger('area')->default(0);
            $table->unsignedTinyInteger('bedroom')->default(0);
            $table->unsignedTinyInteger('bathroom')->default(0);
            $table->longText('description')->nullable();
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->unsignedInteger('zip_code');
            $table->text('img')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
