<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('moderator_id')
                  ->index()
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('moderator_id')
                  ->references('id')
                  ->on('users');

            $table->string('title');
            $table->string('synopsis');
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
        Schema::drop('news');
    }
}
