<?php

use Illuminate\Database\Seeder;
use App\Tables as TablesModels;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {

            DB::beginTransaction();
            $this->_createTableData();
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::info('[dbSeed Exception]: ' . $e);

        }
    }

    /**
     * Create data of table
     */
    private function _createTableData()
    {
        $roles = [
            [
                'name' => 'developer',
                'display_zh_name' => '开发人员',
                'display_en_name' => 'developer',
                'description' => '程序开发者'
            ], [
                'name' => 'admin',
                'display_zh_name' => '管理员',
                'display_en_name' => 'admin',
                'description' => '管理员'
            ], [
                'name' => 'normal',
                'display_zh_name' => '普通用户',
                'display_en_name' => 'normal',
                'description' => '普通用户'
            ],
        ];

        $role_length = count($roles);

        for ($i = 0; $i < $role_length; $i++) {
            $list[] = [
                'name' => $roles[$i]['name'],
                'display_zh_name' => $roles[$i]['display_zh_name'],
                'display_en_name' => $roles[$i]['display_en_name'],
                'description' => $roles[$i]['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        TablesModels\Role::insert($list);
    }
}
