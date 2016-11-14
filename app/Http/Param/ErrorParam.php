<?php

namespace App\Http\Param;

//エラーコード表

class ErrorParam {

    //エラーコード
    const ERR_10001='ERR_10001';
    const ERR_10002='ERR_10002';

    //エラーメッセージ
    public static $ERR_MSG=array(
            self::ERR_10001=>'0で除算できません。',
            self::ERR_10002=>'引数の値が不正です。',
            );
}


