<?php

namespace App;

class CustomValidator extends \Illuminate\Validation\Validator
{

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return int
     */
    public function validateJpZipCode($attribute, $value, $parameters)
    {
        return preg_match("/^[0-9\-]{7,8}+$/i", $value);
    }

    //数値指定された範囲にあるかどうか
    public function validateRangeNumber($attribute, $value, $parameters){
        $this->requireParameterCount ( 2, $parameters, 'rangeNumber' );
        if(is_numeric($value)&&$value>=$parameters[0]&&$value<=$parameters[1]){
            return true;
        }
    }

    //数値が0以上の小数点第n位以下の小数かどうか
    public function validateDecimal($attribute, $value, $parameters){
        $this->requireParameterCount ( 1, $parameters, 'decimal' );
        $value= $value* pow(10,$parameters[0]);
        if(ctype_digit(strval($value))){
            return true;
        }
    }
}