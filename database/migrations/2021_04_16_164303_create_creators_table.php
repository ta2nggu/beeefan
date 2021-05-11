<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creators', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');//users table key
            $table->string('nickname')->nullable();
            $table->integer('month_price')->nullable()->default(0);
            $table->string('instruction', 4000)->nullable();
            $table->string('profile_img')->nullable();
            $table->string('background_img')->nullable();
            $table->integer('follower_cnt')->nullable()->default(0);//회원 수, join 시 증가
            $table->boolean('visible')->default(1);//공개여부, 기본 1 (공개), 0 (비공개)
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
        Schema::dropIfExists('creators');
    }
}
