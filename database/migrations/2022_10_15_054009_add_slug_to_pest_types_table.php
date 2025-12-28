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
        Schema::table('pest_types', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->unique()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('pest_types', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
