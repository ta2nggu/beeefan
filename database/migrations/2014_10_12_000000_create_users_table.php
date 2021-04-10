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
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('sns_url')->nullable();
            $table->timestamp('birth_date')->nullable();
//            21.04.01 김태영, sex 성별, prefecture 도시 추가
            $table->boolean('sex');//1 (남자), 0 (여자)
            $table->integer('prefecture_id')->nullable();


            $table->string('payment_method_id')->nullable();
//            21.03.21 김태영, role_id 제거 laratrust 사용
//            $table->string('role_id')->nullable();;
//            21.03.21 김태영, instruction, profile_img, background_img field 추가
            $table->string('instruction', 4000)->nullable();
            $table->string('profile_img')->nullable();
            $table->string('background_img')->nullable();
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
