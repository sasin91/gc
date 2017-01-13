<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('news_id')
                  ->index()
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('news_id')
                  ->references('id')
                  ->on('news');

            $table->unsignedInteger('author_id')
                  ->index()
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users');

            $table->string('title');
            $table->string('description');
            $table->text('body');
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
        Schema::drop('news_articles');
    }
}
