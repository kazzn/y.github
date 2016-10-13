<?php
namespace App;
use Log;
class LogControl {

protected $_errTable=[
        'E10001'=>'Bad Request',
        'E10002'=>'Unauthorized',
];

function output ($logLevel, $errCode, $options = null)
{
    $errMes = $this->_errTable[$errCode];
    
    if (is_array($options)) {
        foreach ($options as $key => $val) {
            $option[] = $key . ':' . $val;
        }
        if (count($option) > 1) {
            $opt = implode(',', $option);
        } else {
            $opt = $option[0];
        }
    } else {
        $opt = $options;
    }
    
    $errMes .= "(" . $opt . ")";
    
    switch ($logLevel) {
        case 'info':
            Log::info($errMes);
            break;
        case 'notice':
            Log::notice($errMes);
            break;
        case 'warning':
            Log::warning($errMes);
            break;
        case 'error':
            Log::error($errMes);
            break;
        case 'critical':
            Log::critical($errMes);
            break;
        case 'alert':
            Log::alert($errMes);
            break;
        case 'emergency':
            Log::emergency($errMes);
            break;
        default:
            Log::debug($errMes);
    }
}
}

function expand ($arry)
{
    if (is_array($arry)) {
        foreach ($arry as $key => $values) {
            if (is_array($values)) {
                expand($values);
            } else {
                $value[] = $key . ':' . $values;
            }
        }
    }
    return $value;
}