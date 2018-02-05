<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class admins extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*admin的密码为admin*/
        $admin=[
            'username' => "admin",
            'realname' => "超级管理员",
            'password' => '$2y$10$66x80Mfjhj4dLCRtmvmSHOPDDtoXoSjJ5zo92nfFqmcPPX7Go/yoW'
        ];
        $admins=\App\Models\Admins::create($admin);
        $roles=['name'=>'administror',
         'display_name'=>'administror',
            'description'=>'administror'
        ];
        $role=\App\Models\Roles::create($roles);
        $admins->attachRole($role);
        DB::table('permissions')->insert(
            [
                'name'=>'管理列表',
                'display_name'=>'管理列表',
                'link'=>'role.lists',
                'icon'=>'fa-users',
                'pid'=>'-1'
            ]
        );
         $perms=DB::table("permissions")->where('name',"管理列表")->first();
            DB::table('permissions')->insert(
                [
                    'name'=>'用户管理',
                    'display_name'=>'用户管理',
                    'link'=>'admin.lists',
                    'icon'=>'fa-sliders',
                    'pid'=>$perms->id
                ]
            );
             DB::table('permissions')->insert([
              'name'=>'角色管理',
                'display_name'=>'角色管理',
                'link'=>'role.lists',
                'icon'=>'fa-sliders',
                  'pid'=>$perms->id
                    ]);
             DB::table('permissions')->insert([
        'name'=>'栏目管理',
        'display_name'=>'栏目管理',
        'link'=>'permission.lists',
        'icon'=>'fa-sliders',
        'pid'=>$perms->id
        ]);

        DB::table('permissions')->insert(
            [
                'name'=>'新闻管理',
                'display_name'=>'新闻管理',
                'link'=>'',
                'icon'=>'fa-users',
                'pid'=>'-1'
            ]
        );
        $perms1=DB::table("permissions")->where('name',"新闻管理")->first();
        DB::table('permissions')->insert([
            'name'=>'新闻列表',
            'display_name'=>'新闻列表',
            'link'=>'news.lists',
            'icon'=>'fa-sliders',
            'pid'=>$perms1->id
        ]);
        DB::table('permissions')->insert([
            'name'=>'我的新闻',
            'display_name'=>'我的新闻',
            'link'=>'person.lists',
            'icon'=>'fa-sliders',
            'pid'=>$perms1->id
        ]);
        DB::table('permissions')->insert([
            'name'=>'审核通过的新闻',
            'display_name'=>'审核通过的新闻',
            'link'=>'passed.lists',
            'icon'=>'fa-sliders',
            'pid'=>$perms1->id
        ]);
        DB::table('permissions')->insert([
            'name'=>'审核新闻',
            'display_name'=>'审核新闻',
            'link'=>'verify.lists',
            'icon'=>'fa-sliders',
            'pid'=>$perms1->id
        ]);

        DB::table('permissions')->insert(
            [
                'name'=>'报表管理',
                'display_name'=>'报表管理',
                'link'=>'',
                'icon'=>'fa-users',
                'pid'=>'-1'
            ]
        );
        $perms2=DB::table("permissions")->where('name',"报表管理")->first();
        DB::table('permissions')->insert([
            'name'=>'日报表',
            'display_name'=>'日报表',
            'link'=>'report.day',
            'icon'=>'fa-sliders',
            'pid'=>$perms2->id
        ]);
        $permlist=\App\Models\Permissions::all();
              $role->attachPermissions($permlist);
    }
}
