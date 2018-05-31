<?php
    /*后台起始页*/
    Route::get('index', 'HomeController@index');
    /*后台用户管理*/
    Route::get('adminlist', ['uses'=>'AdminController@index','as'=>'admin.lists']);
    Route::get('admins/add/{id?}', ['uses'=>'AdminController@create','as'=>'admin.add']);
    Route::post('admins/add', ['uses'=>'AdminController@store','as'=>'admin.store']);
    Route::post('admins/update/{id}', ['uses'=>'AdminController@update','as'=>'admin.update']);
    Route::post('adminsdelete/{id}', ['uses'=>'AdminController@destroy','as'=>'admin.delete']);
    Route::get('admins/mine/{id?}', ['uses'=>'AdminController@modify','as'=>'admin.mine']);
    /*角色管理*/
    Route::get('rolelist', ['uses'=>'RolesController@index','as'=>'role.lists']);
    Route::get('role/add/{id?}', ['uses'=>'RolesController@create','as'=>'role.add']);
    Route::post('role/add', ['uses'=>'RolesController@store','as'=>'role.store']);
    Route::post('role/update/{id}', ['uses'=>'RolesController@update','as'=>'role.update']);
    Route::post('roledelete/{id}', ['uses'=>'RolesController@destroy','as'=>'role.delete']);
    /*权限管理*/
    Route::get('permissionlist/{id?}', ['uses'=>'PermissionsController@index','as'=>'permission.lists']);
    Route::get('permission/add/{id?}', ['uses'=>'PermissionsController@create','as'=>'permission.add']);
    Route::post('permission/add', ['uses'=>'PermissionsController@store','as'=>'permission.store']);
    Route::post('permission/update/{id}', ['uses'=>'PermissionsController@update','as'=>'permission.update']);
    Route::post('permission/delete/{id}', ['uses'=>'PermissionsController@destroy','as'=>'permission.delete']);
    Route::get('permschild/{pid}', ['uses'=>'PermissionsController@permschild','as'=>'permschild.add']);
    /*新闻管理*/
     Route::get('newslist', ['uses'=>'NewsController@index','as'=>'news.lists']);
     Route::get('news/see/{id}', ['uses'=>'NewsController@see','as'=>'news.see']);

     Route::any('newslist/search', ['uses'=>'NewsController@search','as'=>'news.search']);//搜索的新闻搜索
     Route::any('passed/search', ['uses'=>'NewsController@passed_search','as'=>'passed.search']);//审核通过的新闻进行搜索
     Route::any('person/search', ['uses'=>'NewsController@person_search','as'=>'person.search']);//我的新闻搜索
     Route::post('verify/search', ['uses'=>'NewsController@verify_search','as'=>'verify.search']);//审核新闻搜索
     Route::any('submit/search', ['uses'=>'NewsController@submit_search','as'=>'submit.search']);//提交到早报的新闻搜索

     Route::get('person/news/{id?}', ['uses'=>'NewsController@person','as'=>'person.lists']);
     Route::get('news/passed/{id?}', ['uses'=>'NewsController@passed','as'=>'passed.lists']);
     Route::get('news/verify', ['uses'=>'NewsController@verify','as'=>'verify.lists']);
     Route::get('news/submit/{id?}', ['uses'=>'NewsController@submit','as'=>'submit.lists']);
     Route::post('useful_news/submit/verify', ['uses'=>'NewsController@submitverify','as'=>'useful_news.submit.verify']);//批量提交到审核
     Route::get('useful_news/add/{id?}', ['uses'=>'NewsController@create','as'=>'useful_news.person.add']);/*编辑人员自行添加编辑新闻*/
     Route::get('useful_news/store/{id}', ['uses'=>'NewsController@useful_news','as'=>'useful_news.add']);/*添加已有的新闻*/
     Route::post('useful_news/add', ['uses'=>'NewsController@store','as'=>'useful_news.store']);/*保存个人添加编辑新闻*/
     Route::get('useful_news/option_edit/{id}', ['uses'=>'NewsController@option_edit','as'=>'useful_news.option']);/*加载审核新闻页面*/
     Route::post('useful_news/verify_option/{id}', ['uses'=>'NewsController@verify_option','as'=>'useful_news.verify']);/*审核新闻*/

     Route::post('useful_news/update/{id}', ['uses'=>'NewsController@update','as'=>'useful_news.update']);
     Route::post('useful_news/delete/{id?}', ['uses'=>'NewsController@destroy','as'=>'useful_news.delete']);
     /*早报管理*/
     Route::get('report/day', ['uses'=>'ReportformController@index','as'=>'report.day']);//日报
     Route::post('report/store', ['uses'=>'ReportformController@store','as'=>'report.store']);//日报添加
     Route::get('report/edit/{id}', ['uses'=>'ReportformController@edit','as'=>'report.edit']);//日报编辑
     Route::post('report/update/{id}', ['uses'=>'ReportformController@update','as'=>'report.update']);//日报编辑
     Route::post('report/delete/{id}', ['uses'=>'ReportformController@destroy','as'=>'report.delete']);//删除
     Route::get('report/useful/{id}', ['uses'=>'ReportformController@delete','as'=>'report.useful.delete']);//
     /*专题管理*/
     Route::get('subject/list', ['uses'=>'SubjectController@index','as'=>'subject.lists']);
     Route::get('subject/add/{id?}', ['uses'=>'SubjectController@create','as'=>'subject.add']);
     Route::post('subject/add', ['uses'=>'SubjectController@store','as'=>'subject.store']);
     Route::post('subject/update/{id}', ['uses'=>'SubjectController@update','as'=>'subject.update']);
     Route::post('subject/delete/{id}', ['uses'=>'SubjectController@destroy','as'=>'subject.delete']);
     /*案件类型管理*/
     Route::get('casetype/list/{pid?}', ['uses'=>'CasetypeController@index','as'=>'casetype.lists']);
     Route::get('casetype/add/{id?}', ['uses'=>'CasetypeController@create','as'=>'casetype.add']);
     Route::get('casetype/child/{id}', ['uses'=>'CasetypeController@child','as'=>'casetype.child.add']);
     Route::post('casetype/add', ['uses'=>'CasetypeController@store','as'=>'casetype.store']);
     Route::post('casetype/update/{id}', ['uses'=>'CasetypeController@update','as'=>'casetype.update']);
     Route::post('casetype/delete/{id}', ['uses'=>'CasetypeController@destroy','as'=>'casetype.delete']);
     /*统计*/
     Route::get('tongji/list', ['uses'=>'StatisController@index','as'=>'tongji.lists']);
     Route::get('tongji/info/{id?}', ['uses'=>'StatisController@person','as'=>'tongji.person']);
     Route::post('tongji/search', ['uses'=>'StatisController@search','as'=>'tongji.search']);
     Route::post('tongji/person/search/{id?}', ['uses'=>'StatisController@person_search','as'=>'tongji.search.person']);

     /*获取法院*/
     Route::get('court/list', ['uses'=>'CourtController@index','as'=>'court.list']);

     /*生成报表*/
    Route::get('report/createzip/{id}', ['uses'=>'ReportformController@createzip','as'=>'report.createzip']);//
    Route::get('report/downloadzip/{id}', ['uses'=>'ReportformController@downloadzip','as'=>'report.downloadzip']);//
    Route::get('report/downloaddocx/{id}', ['uses'=>'ReportformController@downloaddocx','as'=>'report.downloaddocx']);//
    Route::get('report/pushzip/{id}', ['uses'=>'ReportformController@pushzip','as'=>'report.pushzip']);//
    Route::get('report/person/createzip', ['uses'=>'ReportformController@createpersonzip','as'=>'report.person.createzip']);//
      /*云词图*/
      Route::get('cloud/index', ['uses'=>'CloudController@index','as'=>'cloud.word']);
      Route::post('cloud/add', ['uses'=>'CloudController@add','as'=>'cloud.add']);
      /*区域倾向性新闻统计*/
      Route::get('tongji/province', ['uses'=>'StatisController@province','as'=>'tongji.province']);
      Route::post('tongji/province', ['uses'=>'StatisController@province_search','as'=>'tongji.province_search']);
      Route::get('tongji/source', ['uses'=>'StatisController@source','as'=>'tongji.source']);
      Route::post('tongji/source', ['uses'=>'StatisController@source_search','as'=>'tongji.source_search']);
      /*排班表*/
      Route::get('schedule/info/{time?}', ['uses'=>'ScheduleController@schedule','as'=>'schedule']);
      Route::post('schedule/update/{id}', ['uses'=>'ScheduleController@update','as'=>'schedule.update']);
      Route::get('schedule/list', ['uses'=>'ScheduleController@list','as'=>'schedule.list']);
      Route::get('schedule/edit/{id}', ['uses'=>'ScheduleController@create','as'=>'schedule.edit']);
      /*周报添加*/
      Route::post('report/week/add', ['uses'=>'WeekformController@store','as'=>'weekform.store']);//周报添加
      Route::get('report/week/list', ['uses'=>'WeekformController@index','as'=>'weekform.list']);//周报列表
      Route::get('report/useful_news/list/{id}', ['uses'=>'WeekformController@newslist','as'=>'weekform.newslist']);//周报列表