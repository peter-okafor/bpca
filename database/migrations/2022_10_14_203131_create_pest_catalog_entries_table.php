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
        Schema::table('ato_z_s', function (Blueprint $table) {
            $table->dropForeign(['pest_id']);
            $table->dropForeign(['pest_type_id']);
            $table->dropForeign(['pest_environment_id']);
        });

        Schema::dropIfExists('ato_z_s');

        Schema::table('pests', function (Blueprint $table) {
            $table->text('abstract')->after('description')->nullable();
            $table->boolean('show_in_a_to_z')->default(true);
            $table->string('image_url', 1020);
            $table->string('website_url', 510);
            $table->string('listing_id', 123)->nullable();
            $table->foreignId('pest_type_id')->nullable()->constrained('pest_types')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedTinyInteger('pest_environment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('pests', function (Blueprint $table) {
            $table->dropForeign(['pest_id']);
            $table->dropForeign(['pest_type_id']);
            $table->dropForeign(['pest_environment_id']);

            $table->dropColumn(['pest_id', 'pest_type_id', 'pest_environment_id']);
        });

        Schema::create('ato_z_s', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('image')->nullable();
            $table->foreignId('pest_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pest_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pest_environment_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
