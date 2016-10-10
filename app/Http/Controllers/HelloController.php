<?php

namespace App\Http\Controllers;

class HelloController extends Controller {
	function index($name){
		return 'こんにちは、'.$name.'さん';
	}
}