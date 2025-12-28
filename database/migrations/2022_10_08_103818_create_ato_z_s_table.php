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
        Schema::create('ato_z_s', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('image')->nullable();
            $table->foreignId('pest_id')->references('id')->on('pests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pest_type_id')->references('id')->on('pest_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pest_environment_id')->references('id')->on('pest_environments')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('ato_z_s');
    }
};
