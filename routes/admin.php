<?php
    /*后台起始页*/
    Route::get('index', 'HomeController@index');
    /*后台用户管理*/
    Route::get('adminlist', ['uses'=>'AdminController@index','as'=>'admin.lists']);
    Route::get('admins/add/{id?}', ['uses'=>'AdminController@create','as'=>'admin.add']);
    Route::post('admins/add', ['uses'=>'AdminController@store','as'=>'admin.store']);
    Route::post('admins/update/{id}', ['uses'=>'AdminController@update','as'=>'admin.update']);
    Route::post('adminsdelete/{id}', ['uses'=>'AdminController@destroy','as'=>'admin.delete']);

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
     Route::get('report/add/{id?}', ['uses'=>'NewsController@create','as'=>'news.add']);
     Route::post('report/add', ['uses'=>'NewsController@store','as'=>'news.store']);
     Route::post('report/update/{id}', ['uses'=>'NewsController@update','as'=>'news.update']);
     Route::post('report/delete/{id}', ['uses'=>'NewsController@destroy','as'=>'news.delete']);
     /*早报管理*/
      Route::get('report/person', ['uses'=>'ReportformController@index','as'=>'report.lists']);
      /*专题管理*/
     Route::get('subject/list', ['uses'=>'SubjectController@index','as'=>'subject.lists']);
     Route::get('subject/add/{id?}', ['uses'=>'SubjectController@create','as'=>'subject.add']);
     Route::post('subject/add', ['uses'=>'SubjectController@store','as'=>'subject.store']);
     Route::post('subject/update/{id}', ['uses'=>'SubjectController@update','as'=>'subject.update']);
     Route::post('subject/delete/{id}', ['uses'=>'SubjectController@destroy','as'=>'subject.delete']);


