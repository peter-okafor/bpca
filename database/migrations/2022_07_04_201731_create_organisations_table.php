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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('external_id');
            $table->string('services');
            $table->string('premises_type');
            $table->string('logo_url');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('town');
            $table->string('postcode');
            $table->string('contact_hours')->nullable();
            $table->text('description')->nullable();
            $table->point('geodata');
            $table->string('email');
            $table->string('telephone');
            $table->string('mobile')->nullable();
            $table->string('accreditation_year')->nullable();
            $table->json('features')->nullable();
            $table->spatialIndex('geodata');
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
        Schema::dropIfExists('organisations');
    }
};
