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
