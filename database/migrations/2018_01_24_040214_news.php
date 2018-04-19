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
            $table->mediumText('content');
            $table->string('author')->nullable();
            $table->string('orientation')->nullable();
            $table->string('firstwebsite')->nullable();
            $table->string('sitetype')->nullable();
            $table->string('link',1000)->nullable();//原文链接
            /*uuid是一个MD5加密的字符串，用来判断文章的唯一性*/
            $table->string('uuid')->nullable();
            $table->string('keywords')->nullable();
            $table->string('subject')->nullable();//涉及专题
            $table->integer('transmit')->default(0);//转发数
            $table->dateTime('starttime');//文章发布时间
            //media_type:1网媒2论坛3博客4,8微博5报刊6微信7视频9APP;10评论；99搜索
            $table->dateTime('media_type');//文章媒体类型
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
