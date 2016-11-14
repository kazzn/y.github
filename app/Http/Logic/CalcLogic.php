<?php

namespace App\Http\Logic;

use App\Http\Exception\DivisionException;
use App\Http\Param\ErrorParam;

class CalcLogic {

    //計算結果
    private $_ans;

    //割り算
    public function division($num1,$num2){

        //例外のスロー
        if(!is_numeric($num1)||!is_numeric($num2)){
            throw new DivisionException(ErrorParam::$ERR_MSG[ErrorParam::ERR_10002]);
        }

        if($num2==0){
            throw new DivisionException(ErrorParam::$ERR_MSG[ErrorParam::ERR_10001]);
        }

        //除算結果
        $this->_ans= $num1/$num2;
    }

    //計算結果の取得
    public function get_ans(){
        return $this->_ans;
    }

}