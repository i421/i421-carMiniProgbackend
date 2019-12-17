<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pheicloud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for pheicloud.
    |
    */

    /**
     * Common
     */
    'common' => [
        'unknown' => '未知',
    ],

    /**
     * Response
     */
    'response' => [
        'success' => [
            'code' => '200',
            'msg' => '成功',
        ],
        'error' => [
            'code' => '10001',
            'msg' => '失败',
        ],
        'empty' => [
            'code' => '204',
            'msg' => '查询结果为空',
        ],
        'normalException' => [
            'code' => '10000',
            'msg' => '异常',
        ],
        'userNotBindRole' => [
            'code' => '10001',
            'msg' => '用户未绑定角色',
        ],
        'notAuth' => [
            'code' => '10002',
            'msg' => '未认证',
        ],
        'exist' => [
            'code' => '10004',
            'msg' => '已经存在，请重试',
        ],
        'notExist' => [
            'code' => '10005',
            'msg' => '不存在，请重试',
        ],
        'codeNotMatch' => [
            'code' => '10006',
            'msg' => '验证码不匹配',
        ],
        'codeInvalid' => [
            'code' => '10007',
            'msg' => '验证码失效. 请重新获取验证码',
        ],
        'passwordNotSameAsBefore' => [
            'code' => '10008',
            'msg' => '原密码不正确',
        ],
        'missingParams' => [
            'code' => '20000',
            'msg' => '缺失参数',
        ],
        'illegalParams' => [
            'code' => '20001',
            'msg' => '不合法的参数',
        ],
        'phoneFormatError' => [
            'code' => '20002',
            'msg' => '手机号格式错误',
        ],
        'fileNotValid' => [
            'code' => '20003',
            'msg' => '文件不合法',
        ],
        'fileTooLarge' => [
            'code' => '20004',
            'msg' => '上传文件(图片)太大, 最大限制kb:',
        ],
        'requestPayError' => [
            'code' => '20005',
            'msg' => '请求支付失败',
        ],
        'groupOutOfRange' => [
            'code' => '70001',
            'msg' => '超出拼团数量',
        ],
        'orderOutOfRange' => [
            'code' => '70002',
            'msg' => '每日订单超过限制',
        ],
        'alreadyBind' => [
            'code' => '71000',
            'msg' => 'already bind',
        ],
        'outOfRange' => [
            'code' => '71003',
            'msg' => '积分不足',
        ],
    ],
];
