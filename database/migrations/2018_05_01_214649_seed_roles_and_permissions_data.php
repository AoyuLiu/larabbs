<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{

    public function up()
    {  //清除缓存
       app()['cache']->forget('spatie.permission.cache');
       Permission::create(['name' => 'manage_contents']);
       Permission::create(['name'=>'manage_users']);
       Permission::create(['name'=>'edit_settings']);
       //站长
       $founder = Role::create(['name'=>'Founder']);
       $founder->givePermissionTo('manage_contents');
       $founder->givePermissionTo('manage_users');
       $founder->givePermissionTo('edit_settings');

      //管理员
      $maintainer = Role::create(['name'=>'maintainer']);
      $maintainer->givePermissionTo('manage_contents');
    }


    public function down()
    {
        app()['cache']->forget('spatie.permission.cache');

        $tableNames = config('permission.table_names');
        //解除自动填充操作的限制？
        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
