<?php

use Illuminate\Database\Seeder;
use App\Tables as TableModels;
use Carbon\Carbon;

class TagTableSeeder extends Seeder
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
                'tag_group' => '级别',
                'name' => '轿车',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '级别',
                'name' => 'SUV',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '级别',
                'name' => 'MPV',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '级别',
                'name' => '跑车',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '级别',
                'name' => '皮卡',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '级别',
                'name' => '其他',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '中国',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '德国',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '日本',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '美国',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '韩国',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '法国',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '英国',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '意大利',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '国别',
                'name' => '其他国别',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '厂商属性',
                'name' => '国产',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '厂商属性',
                'name' => '合资',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '厂商属性',
                'name' => '进口',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '动力参数',
                'name' => '手动',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '动力参数',
                'name' => '自动',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '能源',
                'name' => '汽油',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '能源',
                'name' => '柴油',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '能源',
                'name' => '汽油+48V轻混系统',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '纯电续航里程',
                'name' => '100KM以内',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '纯电续航里程',
                'name' => '100KM-200KM',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '纯电续航里程',
                'name' => '200KM-300KM',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '纯电续航里程',
                'name' => '300KM-400KM',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '纯电续航里程',
                'name' => '400KM+',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '1.0及以下',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '1.1-1.6L',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '1.7-2.0L',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '2.1-2.5L',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '2.6-3.0L',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '3.1-4.0L',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '排量',
                'name' => '4.0L+',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '100及以下',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '101-150',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '151-200',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '201-250',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '251-300',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '301-400',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '马力',
                'name' => '400以上',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '进气方式',
                'name' => '自然吸气',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '进气方式',
                'name' => '涡轮增压',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '进气方式',
                'name' => '机械增压',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '环保标准',
                'name' => '国四',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '环保标准',
                'name' => '国五',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '环保标准',
                'name' => '国六',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '供油方式',
                'name' => '直喷',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '供油方式',
                'name' => '多点电喷',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '供油方式',
                'name' => '混合喷射',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '燃油标号',
                'name' => '92',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '燃油标号',
                'name' => '95',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '燃油标号',
                'name' => '98',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '燃油标号',
                'name' => '柴油',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '驱动方式',
                'name' => '前驱',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '驱动方式',
                'name' => '后驱',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '驱动方式',
                'name' => '四驱',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '驻车制动类型',
                'name' => '手刹',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '驻车制动类型',
                'name' => '脚刹',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'tag_group' => '驻车制动类型',
                'name' => '电子驻车',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        TableModels\Tag::insert($list);
    }
}
