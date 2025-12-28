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
        Schema::table('postcodes', function (Blueprint $table) {
            $table->dropForeign(['parent_postcode_id']);
            $table->dropForeign(['locality_id']);

            $table->dropColumn(['parent_postcode_id', 'locality_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postcodes', function (Blueprint $table) {
            $table->foreignId('parent_postcode_id')->constrained('postcodes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('locality_id')->constrained('localities')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
