<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');//작성자, 크리에이터 id
            $table->longText('msg')->nullable();//코멘트
            $table->timestamp('release_at');//게시일
            $table->boolean('visible')->default(1);//공개여부, 기본 1 (공개), 0 (비공개)
            //21.03.21 김태영, 대표 이미지, 비디오 포함 여부, 파일 개수 추가
            $table->string('main_img')->nullable();
            $table->integer('main_img_idx')->nullable();
            $table->boolean('include_video')->default(0);
            $table->integer('file_cnt')->default(0);
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
        Schema::dropIfExists('tweets');
    }
}
