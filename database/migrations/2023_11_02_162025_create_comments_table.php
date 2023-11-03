<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('referral_id');
            $table->unsignedBigInteger('user_id');
            $table->text('text');
            $table->timestamps();
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
