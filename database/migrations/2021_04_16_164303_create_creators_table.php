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
