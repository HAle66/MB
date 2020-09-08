<?php


namespace app\index\validate;
use think\Validate;

class msg extends Validate
{
    protected $rule = [
        'content|内容'    =>  'require',

    ];

    protected $message = [
        'content.require'   =>  '留言内容不可为空',
    ];

}