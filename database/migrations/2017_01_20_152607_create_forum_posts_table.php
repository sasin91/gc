<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('forum_thread_id');
            $table->foreign('forum_thread_id')
                  ->references('id')
                  ->on('forum_threads')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unsignedInteger('author_id')->nullable();
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users');

            $table->text('content');

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
        Schema::dropIfExists('table');
    }
}
