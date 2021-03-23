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
            $table->string('password');
            $table->rememberToken();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('sns_url')->nullable();
            $table->timestamp('birth_date')->nullable();
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
