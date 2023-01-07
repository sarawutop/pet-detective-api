<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\LostPet::class);
            $table->string('name');
            $table->string('type');
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('breed')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('collar')->nullable();
            $table->string('leg_ring')->nullable();
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
        Schema::dropIfExists('pet_details');
    }
};
