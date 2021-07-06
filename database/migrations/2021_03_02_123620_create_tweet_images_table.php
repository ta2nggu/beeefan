<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweet_images', function (Blueprint $table) {
//            $table->id();
            $table->increments('id');
            $table->bigInteger('tweet_id');
            $table->integer('idx');
            $table->string('name', 1000);
            $table->string('mime_type', 20);
            $table->boolean('private')->default(0);//1 (전체공개), 0 (회원공개)
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
        Schema::dropIfExists('tweet_images');
    }
}
