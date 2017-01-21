<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('forum_category_id');
            $table->foreign('forum_category_id')
                  ->references('id')
                  ->on('forum_categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unsignedInteger('author_id')->nullable();
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade');

            $table->string('title');
            $table->string('description');
            $table->boolean('pinned');
            $table->boolean('locked');
            $table->boolean('popular');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_threads');
    }
}
