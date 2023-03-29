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
        Schema::create('lost_pets', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable()->default(null);
            $table->string('location');
            $table->dateTime('lost_at');
            $table->string('description');
            $table->string('contact_info');
            $table->string('status')->default('not found');
            $table->decimal('latitude', 10, 7)->nullable()->default(null);
            $table->decimal('longitude', 10, 7)->nullable()->default(null);
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
        Schema::dropIfExists('lost_pets');
    }
};
