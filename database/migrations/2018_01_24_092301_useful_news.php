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
            $table->unsignedInteger('news_id')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->string('title');
            $table->text('content');
            $table->string('author')->nullable();
            $table->string('firstwebsite')->nullable();
            $table->string('sitetype')->nullable();
            $table->string('link')->nullable();//原文链接
            /*uuid是一个MD5加密的字符串，用来判断文章的唯一性*/
            $table->string('uuid')->nullable();
            $table->string('keywords')->nullable();
            //文章转发数
            $table->integer('transmit')->default(0);//转发数
              /*
              -2：退回，新闻不合格
              -1：未审核
              0: 保存不提交到审核(仅编辑人员个人查看修改)
              1：审核通过并提交到早报
              2：审核通过判为重复
              */
            $table->integer('tag')->default(0);
            $table->string('verify_option',500)->nullable();//审核意见
            $table->string('court')->nullable();//涉及法院
            $table->text('abstract')->nullable();//摘要
            $table->dateTime('starttime')->nullable();//发起时间
            $table->integer('visitnum')->default(0);
            $table->integer('replynum')->default(0);
            $table->string('orientation')->nullable();//倾向性
            $table->integer('ispush')->default(1);//是否推送到大屏
            $table->string('yuqinginfo')->nullable();//舆情信息
            $table->string('screen')->nullable();
            $table->string('md5')->nullable();
            $table->integer('isrepeats')->default(0);//舆情是否反复出现;1:反复出现
            $table->integer('isedit')->default(0);//编辑人员是否已经编辑过
            $table->string('oldsubject')->nullable();//文章抓取所属专题
            $table->string('areacode')->nullable();//专题id
            $table->unsignedInteger('subject_id')->nullable();//专题id
            $table->unsignedInteger('reportform_id')->nullable();//早报id
            $table->unsignedInteger('casetype_id')->nullable();//案件类型id

            $table->foreign('news_id')->references('id')->on('news')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('areacode')->references('areacode')->on('address')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subject')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reportform_id')->references('id')->on('reportform')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('casetype_id')->references('id')->on('casetype')
                ->onUpdate('cascade')->onDelete('cascade');
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
