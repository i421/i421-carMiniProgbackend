<?php

use Illuminate\Database\Seeder;
use App\Tables as TableModels;
use Carbon\Carbon;

class BrandTableSeeder extends Seeder
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
            \Log::info('[tag dbSeed Exception]: ' . $e);

        }
    }

    /**
     * Create data of table
     */
    private function _createTableData()
    {
        $list = [
            [
                'name' => '奥迪',
                'head' => 'A',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '阿尔法·罗密欧',
                'head' => 'A',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '本田',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '宝马',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '奔驰',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '别克',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '比亚迪',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '保时捷',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '标致',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '宝骏',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '奔腾',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '宾利',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '北京',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '北汽新能源',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '宝沃',
                'head' => 'B',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '长安',
                'head' => 'C',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '长城',
                'head' => 'C',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '大众',
                'head' => 'D',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '东风',
                'head' => 'D',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => 'DS',
                'head' => 'D',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '丰田',
                'head' => 'F',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '福特',
                'head' => 'F',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '菲亚特',
                'head' => 'F',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '广汽传祺',
                'head' => 'G',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '哈佛',
                'head' => 'H',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '红旗',
                'head' => 'H',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '吉利汽车',
                'head' => 'J',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => 'Jeep',
                'head' => 'J',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '捷豹',
                'head' => 'J',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '凯迪拉克',
                'head' => 'K',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '雷克萨斯',
                'head' => 'L',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '领克',
                'head' => 'L',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '路虎',
                'head' => 'L',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '林肯',
                'head' => 'L',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '雷诺',
                'head' => 'L',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '陆风',
                'head' => 'L',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '马自达',
                'head' => 'M',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '名爵',
                'head' => 'M',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '玛萨拉蒂',
                'head' => 'M',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => 'MINI',
                'head' => 'M',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '讴歌',
                'head' => 'O',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '起亚',
                'head' => 'Q',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '奇瑞',
                'head' => 'Q',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '日产',
                'head' => 'R',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '斯柯达',
                'head' => 'S',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '三菱',
                'head' => 'S',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '斯巴鲁',
                'head' => 'S',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '特斯拉',
                'head' => 'T',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '沃尔沃',
                'head' => 'W',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '五菱汽车',
                'head' => 'W',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => 'WEY',
                'head' => 'W',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '蔚来',
                'head' => 'W',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '现代',
                'head' => 'X',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '雪佛兰',
                'head' => 'X',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '雪铁龙',
                'head' => 'X',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '英菲尼迪',
                'head' => 'Y',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '一汽',
                'head' => 'Y',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => '众泰',
                'head' => 'Z',
                'logo' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        TableModels\Brand::insert($list);
    }
}
