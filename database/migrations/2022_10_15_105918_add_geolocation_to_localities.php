<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('localities', function (Blueprint $table) {
            $table->point('latlng')->nullable();
            $table->polygon('geodata')->nullable();
            $table->unsignedSmallInteger('type'); //LocalityTypeEnum
            $table->boolean('has_locality_data')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('localities', function (Blueprint $table) {
            $table->dropColumn('has_locality_data');
            $table->dropColumn('type');
            $table->dropColumn('geodata');
            $table->dropColumn('latlng');
        });
    }
};
