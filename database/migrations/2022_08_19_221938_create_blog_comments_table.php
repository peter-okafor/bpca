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
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->foreignId('blog_post_id')->references('id')->on('blog_posts')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('parent_id', false, true)->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('blog_comments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comments');
    }
};
