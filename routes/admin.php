<?php
    /*后台起始页*/
    Route::get('index', 'HomeController@index');
    /*后台用户管理*/
    Route::get('adminlist', ['uses'=>'AdminController@index','as'=>'admin.lists']);
    Route::get('adminsadd/{id?}', ['uses'=>'AdminController@create','as'=>'admin.add']);
    Route::post('adminsadd', ['uses'=>'AdminController@store','as'=>'admin.store']);
    Route::post('adminsupdate/{id}', ['uses'=>'AdminController@update','as'=>'admin.update']);
    Route::post('adminsdelete/{id}', ['uses'=>'AdminController@destroy','as'=>'admin.delete']);

    /*角色管理*/
    Route::get('rolelist', ['uses'=>'RolesController@index','as'=>'role.lists']);
    Route::get('roleadd/{id?}', ['uses'=>'RolesController@create','as'=>'role.add']);
    Route::post('roleadd', ['uses'=>'RolesController@store','as'=>'role.store']);
    Route::post('roleupdate/{id}', ['uses'=>'RolesController@update','as'=>'role.update']);
    Route::post('roledelete/{id}', ['uses'=>'RolesController@destroy','as'=>'role.delete']);

    /*权限管理*/
    Route::get('permissionlist/{id?}', ['uses'=>'PermissionsController@index','as'=>'permission.lists']);
    Route::get('permissionadd/{id?}', ['uses'=>'PermissionsController@create','as'=>'permission.add']);
    Route::post('permissionadd', ['uses'=>'PermissionsController@store','as'=>'permission.store']);
    Route::post('permissionupdate/{id}', ['uses'=>'PermissionsController@update','as'=>'permission.update']);
    Route::post('permissiondelete/{id}', ['uses'=>'PermissionsController@destroy','as'=>'permission.delete']);
    Route::get('permschild/{pid}', ['uses'=>'PermissionsController@permschild','as'=>'permschild.add']);




