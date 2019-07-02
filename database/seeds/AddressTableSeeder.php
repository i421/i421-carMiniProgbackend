<?php

use Illuminate\Database\Seeder;
use App\Tables as TableModels;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //read level4 from json file
        $filePath = __DIR__ . '/../files/level4.json';
        $addressStr = file_get_contents($filePath);
        $addressArr = json_decode($addressStr, true);

        try {

            DB::beginTransaction();
            $this->_createAddress($addressArr);
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::info('[address dbSeed Exception]: ' . $e);

        }
    }

    /**
     * 权限数据
     *
     * @param  array $permissionArr
     * @return void
     */
    private function _createAddress(array $address)
    {
        TableModels\Address::insert([
            'id' => $address['divisionId'],
            'division_code' => $address['divisionCode'],
            'division_level' => $address['divisionLevel'],
            'pinyin' => $address['pinyin'],
            'division_name' => $address['divisionName'],
            'division_t_name' => $address['divisionTname'],
            'division_abb_name' => $address['divisionAbbName'],
            'is_deleted' => $address['isdeleted'],
            'p_id' => $address['parentId'],
        ]);

        $flag = isset($address['children']);

        if ($flag && $address['divisionLevel'] == 1) {
            //遍历省份
            foreach ($address['children'] as $atom2) {
                //插入省份
                TableModels\Address::insert([
                    'id' => $atom2['divisionId'],
                    'division_code' => $atom2['divisionCode'],
                    'division_level' => $atom2['divisionLevel'],
                    'pinyin' => $atom2['pinyin'],
                    'division_name' => $atom2['divisionName'],
                    'division_t_name' => $atom2['divisionTname'],
                    'division_abb_name' => $atom2['divisionAbbName'],
                    'is_deleted' => $atom2['isdeleted'],
                    'p_id' => $atom2['parentId'],
                ]);

                $f2 = isset($atom2['children']);

                if ($f2 && $atom2['divisionLevel'] == 2) {

                    //遍历市
                    foreach ($atom2['children'] as $atom3) {
                        //插入市
                        TableModels\Address::insert([
                            'id' => $atom3['divisionId'],
                            'division_code' => $atom3['divisionCode'],
                            'division_level' => $atom3['divisionLevel'],
                            'pinyin' => $atom3['pinyin'],
                            'division_name' => $atom3['divisionName'],
                            'division_t_name' => $atom3['divisionTname'],
                            'division_abb_name' => $atom3['divisionAbbName'],
                            'is_deleted' => $atom3['isdeleted'],
                            'p_id' => $atom3['parentId'],
                        ]);

                        $f3 = isset($atom3['children']);

                        if ($f3 && $atom3['divisionLevel'] == 3) {

                            //遍历区
                            foreach ($atom3['children'] as $atom4) {
                                //插入区
                                $list [] = [
                                    'id' => $atom4['divisionId'],
                                    'division_code' => $atom4['divisionCode'],
                                    'division_level' => $atom4['divisionLevel'],
                                    'pinyin' => $atom4['pinyin'],
                                    'division_name' => $atom4['divisionName'],
                                    'division_t_name' => $atom4['divisionTname'],
                                    'division_abb_name' => $atom4['divisionAbbName'],
                                    'is_deleted' => $atom4['isdeleted'],
                                    'p_id' => $atom4['parentId'],
                                ];
                            }

                            TableModels\Address::insert($list);
                            $list = [];
                        }
                    }
                }
            }
        }
    }
}
