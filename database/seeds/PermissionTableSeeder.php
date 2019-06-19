<?php

use Illuminate\Database\Seeder;
use App\Tables as TableModels;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //read permissions from json file
        $filePath = __DIR__ . '/../files/permissions.json';
        $permissionStr = file_get_contents($filePath);
        $permissionArr = json_decode($permissionStr, true);

        try {

            DB::beginTransaction();
            $this->_createPermissions($permissionArr);
            $this->_createPermissionRoles(count($permissionArr));
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::info('[dbSeed Exception]: ' . $e);

        }
    }

    /**
     * 权限数据
     *
     * @param  array $permissionArr
     * @return void
     */
    private function _createPermissions(array $permissionArr)
    {
        foreach ($permissionArr as $permission) {
            $list[] = [
                'id' => $permission['id'],
                'name' => $permission['name'],
                'display_zh_name' => $permission['display_zh_name'],
                'display_en_name' => $permission['display_en_name'],
                'icon' => $permission['icon'],
                'is_menu' => $permission['is_menu'],
                'pid' => $permission['pid'],
                'order' => $permission['order'],
            ];
        }

        TableModels\Permission::insert($list);
    }

    /**
     * 权限角色中枢表数据
     *
     * @param  int $length
     * @return void
     */
    private function _createPermissionRoles(int $length)
    {
        //developer permissions
        for ($i = 1; $i <= $length; $i++) {
            $list[] = [
                'role_id' => '1',
                'permission_id' => $i,
            ];
        }

        //admin permissions
        for ($i = 1; $i <= $length; $i++) {
            $list[] = [
                'role_id' => '2',
                'permission_id' => $i,
            ];
        }

        DB::table('permission_role')->insert($list);
    }
}
