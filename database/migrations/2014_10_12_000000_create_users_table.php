<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
//            21.04.01 김태영, account_id 추가
            $table->string('account_id', 20)->unique();
            $table->string('password');
            $table->rememberToken();
//            $table->string('name')->nullable();
            //21.04.15 김태영, 성, 이름으로 변경(last_name, first_name)
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            //21.04.17 김태영, nickname creators 테이블로 이동
//            $table->string('nickname')->nullable();
            //21.04.17 김태영, sns_url field 제거
            //$table->string('sns_url')->nullable();
            $table->timestamp('birth_date')->nullable();
//            21.04.01 김태영, sex 성별, prefecture 도시 추가
            $table->boolean('sex')->nullable();//1 (남자), 0 (여자)
            $table->integer('prefecture_id')->nullable();
            //21.04.17 김태영, month_price creators 테이블로 이동
            //21.04.15 김태영, 월액 추가
//            $table->integer('month_price')->nullable()->default(0);


            $table->string('payment_method_id')->nullable();
//            21.03.21 김태영, role_id 제거 laratrust 사용
//            $table->string('role_id')->nullable();;

            //21.04.17 김태영, instruction, profile_img, background_img creators 테이블로 이동
//            21.03.21 김태영, instruction, profile_img, background_img field 추가
//            $table->string('instruction', 4000)->nullable();
//            $table->string('profile_img')->nullable();
//            $table->string('background_img')->nullable();
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
        Schema::dropIfExists('users');
    }
}
