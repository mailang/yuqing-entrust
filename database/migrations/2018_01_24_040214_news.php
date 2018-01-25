<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class News extends Migration
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
            $table->string('title');
            $table->string('content');
            $table->string('author')->nullable();
            $table->string('orientation')->nullable();
            $table->string('firstwebsite')->nullable();
            $table->string('sitetype')->nullable();
            $table->string('link')->nullable();//原文链接
            /*uuid是一个MD5加密的字符串，用来判断文章的唯一性*/
            $table->string('uuid');
            $table->string('keywords')->nullable();
            $table->string('subject')->nullable();//涉及专题
            $table->integer('transmit')->default(0);//转发数
            $table->dateTime('starttime');//文章发布时间
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
        Schema::dropIfExists('news');
    }
}
