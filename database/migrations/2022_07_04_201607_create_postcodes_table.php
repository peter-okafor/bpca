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
        Schema::create('postcodes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->polygon('geodata');
            $table->timestamps();
        });

        Schema::table('postcodes', function (Blueprint $table) {
            $table->foreignId('parent_postcode_id')->constrained('postcodes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('locality_id')->constrained('localities')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postcodes');
    }
};
