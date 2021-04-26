<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('creator_id');
            $table->date('next_payment_date')->nullable();
            $table->boolean('payment_status')->default(0);//1 결제 완료, 0 결제 전
            $table->boolean('cancel')->default(0);//1 취소 요청, 0 취소 요청 없음
            $table->integer('payment_method_id')->nullable();//결제 방식
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
        Schema::dropIfExists('followings');
    }
}
