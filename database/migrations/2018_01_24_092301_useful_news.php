<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsefulNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useful_news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned;
            $table->string('title');
            $table->string('content');
            $table->string('author')->nullable();
            $table->string('firstwebsit')->nullable();
            $table->string('sitetype')->nullable();
            $table->string('link')->nullable();//原文链接
            /*uuid是一个MD5加密的字符串，用来判断文章的唯一性*/
            $table->string('uuid');
            $table->string('keywords')->nullable();
            //文章转发数
            $table->integer('transmit')->default(0);//转发数
              /* -1：未审核
              0: 保存不提交到审核(仅编辑人员个人查看修改)
              1：审核通过并提交到早报
              2：审核通过判为重复
              3：退回，新闻不合格*/
            $table->string('tag')->nullable();
            $table->string('court')->nullable();//涉及法院
            $table->string('address_id')->unsigned;
            $table->string('abstract')->nullable();//摘要
            $table->dateTime('starttime')->nullable();//发起时间
            $table->string('visitnum')->nullable;
            $table->string('replynum')->nullable;
            $table->string('orientation')->nullable;//倾向性
            $table->string('ispush')->nullable;//是否推送到大屏
            $table->string('yuqinginfo')->nullable;//舆情信息
            $table->string('screen')->nullable;
            $table->string('subject_id')->nullable;//专题id
            $table->string('reportform_id')->nullable;//早报id
            $table->string('casetype_id')->nullable;//早报id

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('address')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subject')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reportform_id')->references('id')->on('reportform')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('casetype_id')->references('id')->on('casetype')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('useful_news');
    }
}
