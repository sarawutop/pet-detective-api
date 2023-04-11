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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\FoundPet::class)->nullable(); // foreign key `found_pet_id`
            $table->foreignIdFor(\App\Models\LostPet::class)->nullable(); // foreign key `lost_pet_id`
            $table->text('message');
            $table->timestamps();
            $table->softDeletes();    // `deleted_at`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
