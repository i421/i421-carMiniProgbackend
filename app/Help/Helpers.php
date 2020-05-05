<?php
/*
|--------------------------------------------------------------------------
| Global function
|--------------------------------------------------------------------------
| 
| define common methods for the system
*/

use App\Tables as TableModels;

/**
 * aes解密
 *
 * @param  string $str
 * @return string $decrypt_str
 */
function aesDecrypt($str)
{
    $decrypted = openssl_decrypt(base64_decode($str), 'aes-128-cbc', \AES_KEY, OPENSSL_RAW_DATA, \AES_IV);

    return $decrypted;
}

/**
 * aes加密
 *
 * @param  string $plain_text
 * @return string $encode_string
 */
function aesEncrypt($plain_text)
{
    $encrypted_data = openssl_encrypt($plain_text, 'aes-128-cbc', \AES_KEY, OPENSSL_RAW_DATA, \AES_IV);

    return base64_encode($encrypted_data);
}


/**
 * 菜单树
 *
 * @param  array $items 菜单数组
 * @return array $menus 格式化后数组
 */
function generateTree($items)
{
    $tree = [];

    foreach ($items as $item) {
        if ($item['pid'] != 0) {
            foreach ($tree as $k => & $v) {
                if ($v['id'] == $item['pid']) {
                    $v['child'][] = $item;
                    $v['child'] = sortMultidimArray($v['child'], 'order', 'asc');
                }
            }
        } else {
            array_push($tree, $item);
        }
    }

    $tree = sortMultidimArray($tree, 'order', 'asc');
    return array_filter($tree);
}

/**
 * 多维数组排序
 *
 * @param  array $list
 * @param  string $field
 * @param  string $sortby
 * @return array/boolean $resultSet/false
 */
function sortMultidimArray(array $list, string $field, string $sortby = 'asc')
{
    if (is_array($list)) {

        $refer = $resultSet = []; 

        foreach ($list as $i => $data) {
            $refer[$i] = &$data[$field];
        }

        switch ($sortby) {
            case 'asc':
                asort($refer);
                break;
            case 'desc':
                arsort($refer);
                break;
            case 'nat':
                natcasesort($refer);
                break;
        }

        foreach ($refer as $key => $val) {
            $resultSet[] = &$list[$key];
        }

        return $resultSet;
    }

    return false;
}

/**
 * 根据子节点ID获取整个地址
 */
function getFullByAddressId($id, $address = '')
{
    $nav = TableModels\Address::find($id);

    if($nav['p_id'] != 0) {
        $address = $nav->division_name . $address;
        return getFullByAddressId($nav['p_id'], $address);
    }

    return $address;
}

function getScoreThreshold()
{
    $score = TableModels\Setting::where('key', 'score')->first();

    if (is_null($score)) {
        $data = ['store' => 100, 'recommend' => 100];
    } else {
        $data = json_decode($score->value, true);
    }

    return $data;
}

function getMoneyThreshold()
{
    $money = TableModels\Setting::where('key', 'v4_money_ratio')->first();

    if (is_null($money)) {
        $data = ['agent_return_money' => 0, 'relation_return_money' => 0, 'partner_cannot_recycle_ratio' => 50];
    } else {
        $data = json_decode($money->value, true);
    }

    return $data;
}

function checkFileSize($size, $limit)
{
    if ($size > $limit) {
        $response = [
            'code' => trans('pheicloud.response.fileTooLarge.code'),
            'msg' => trans('pheicloud.response.fileTooLarge.msg') . $limit,
        ];
        return [
            'flag' => false,
            'data' => $response,
        ];
    } else {
        return [
            'flag' => true,
            'data' => '',
        ];
    }
}

function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $EARTH_RADIUS = 6378.137;

    $distanceRadLat1 = distanceRad($lat1);
    $distanceRadLat2 = distanceRad($lat2);
    $a = $distanceRadLat1 - $distanceRadLat2;
    $b = distanceRad($lng1) - distanceRad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($distanceRadLat1) * cos($distanceRadLat2) * pow(sin($b / 2), 2)));
    $s = $s * $EARTH_RADIUS;
    $s = round($s * 10000) / 10000;

    return $s;
}

function distanceRad($d)
{
    return $d * M_PI / 180.0;
}

/*
 * 获取某个会员的无限下级方法
 * $members是所有会员数据表,$mid是用户的id
*/
function getTeamMember($members, $mid) {
    $Teams = array();
    $mids = array($mid);
    do {
        $othermids = array();
        $state = false;
        foreach ($mids as $valueone) {
            foreach ($members as $key => $valuetwo) {
                if($valuetwo['recommender'] == $valueone){
                    $Teams[] = $valuetwo['id'];
                    $othermids[] = $valuetwo['id'];
                    //array_splice($members, $key, 1);//从所有会员中删除他
                    $state = true;
                }
            }
        }
        $mids = $othermids;
    } while ($state == true);

    return $Teams;
}

function classifyTree($items)
{
    $tree = [];

    foreach ($items as $item) {
        if ($item['pid'] != 0) {
            foreach ($tree as $k => & $v) {
                if ($v['id'] == $item['pid']) {
                    $v['child'][] = $item;
                    $v['child'] = sortMultidimArray($v['child'], 'order', 'desc');
                }
            }
        } else {
            array_push($tree, $item);
        }
    }

    $tree = sortMultidimArray($tree, 'order', 'desc');
    return array_filter($tree);
}
