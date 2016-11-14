<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Http\Logic\CalcLogic;
use App\Http\Exception\DivisionException;

class ExceptionController extends Controller {

    function example001(){
        try{
            $calc= new CalcLogic();
            $calc->division('abcd1',0);
            $ans= $calc->get_ans();
            return '答え：'.$ans;
        }catch(DivisionException $e){
            return '(DivisionException)エラーが発生しました。:'.$e->getMessage();
        }catch(\Exception $e){
            return '(Exception)エラーが発生しました。：'.$e->getMessage();
        }
    }

}