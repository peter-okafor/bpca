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
        Schema::create('pest_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pest_id');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();

            $table->foreign('pest_id')
                ->references('id')
                ->on('pests')
                ->onDelete('cascade');

            $table->foreign('service_id')
            ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pest_services');
    }
};
