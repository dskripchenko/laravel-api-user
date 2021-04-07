<?php

use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class RegisterDefaultRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('user_permissions')->insert([
            'key' => 'role.create',
            'name' => 'Создание ролей',
            'group' => 'Управление ролями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'role.read',
            'name' => 'Получение информации о ролях',
            'group' => 'Управление ролями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'role.update',
            'name' => 'Редактирование ролей',
            'group' => 'Управление ролями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'role.delete',
            'name' => 'Удаление ролей',
            'group' => 'Управление ролями',
        ]);



        DB::table('user_permissions')->insert([
            'key' => 'permission.create',
            'name' => 'Создание пермишена',
            'group' => 'Управление ролями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'permission.read',
            'name' => 'Получение информации о пермишенах',
            'group' => 'Управление ролями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'permission.update',
            'name' => 'Редактирование пермишенов',
            'group' => 'Управление ролями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'permission.delete',
            'name' => 'Удаление пермишенов',
            'group' => 'Управление ролями',
        ]);



        DB::table('user_permissions')->insert([
            'key' => 'user.create',
            'name' => 'Создание пользователей',
            'group' => 'Управление пользователями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'user.read',
            'name' => 'Получение информации о пользователях',
            'group' => 'Управление пользователями',
        ]);


        DB::table('user_permissions')->insert([
            'key' => 'user.update',
            'name' => 'Редактирование пользователей',
            'group' => 'Управление пользователями',
        ]);

        DB::table('user_permissions')->insert([
            'key' => 'user.delete',
            'name' => 'Удаление пользователей',
            'group' => 'Управление пользователями',
        ]);



        DB::table('user_roles')->insert([
            'key' => 'root',
            'name' => 'root'
        ]);

        DB::table('user_roles')->insert([
            'key' => 'user.admin',
            'name' => 'Администрирование пользователей'
        ]);

        DB::table('user_roles')->insert([
            'key' => 'role.admin',
            'name' => 'Управление ролями'
        ]);

        DB::table('user_roles')->insert([
            'key' => 'permission.admin',
            'name' => 'Управление пермишенами'
        ]);


        $roleAdminRole = DB::table('user_roles')->where('key', 'role.admin')->first();
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $roleAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'role.create')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $roleAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'role.read')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $roleAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'role.update')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $roleAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'role.delete')->first()->id,
        ]);

        $permissionAdminRole = DB::table('user_roles')->where('key', 'permission.admin')->first();
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $permissionAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'permission.create')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $permissionAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'permission.read')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $permissionAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'permission.update')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $permissionAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'permission.delete')->first()->id,
        ]);

        $userAdminRole = DB::table('user_roles')->where('key', 'user.admin')->first();
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $userAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'user.create')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $userAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'user.read')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $userAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'user.update')->first()->id,
        ]);
        DB::table('user_role2user_permissions')->insert([
            'user_role_id' => $userAdminRole->id,
            'user_permission_id' =>  DB::table('user_permissions')->where('key', 'user.delete')->first()->id,
        ]);



        $rootUser = DB::table('users')->where('name', 'root')->first();
        $rootRole = DB::table('user_roles')->where('key', 'root')->first();

        DB::table('user2user_roles')->insert([
            'user_id' => $rootUser->id,
            'user_role_id' => $rootRole->id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
