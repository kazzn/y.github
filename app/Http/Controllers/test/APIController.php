<?php

namespace App\Http\Controllers\test;

use DB;
use App\Form;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;

class APIController extends Controller {
	//ユーザ一覧のAPI
	function getList(){
		//$data=DB::select('select * from form');
		$data= Form::all();
		return response()->json($data); //処理の結果をJSON形式で返す
	}

	//ユーザ登録のAPI
	function addList(Request $request){

		$form = new Form();

		//データの取得
		$data = $request->all();
		$form->user= $data['user'];
		$form->mail= $data['mail'];
		$form->sex= $data['sex'];
		$form->pref= $data['pref'];

		//バリデーションチェック
		$rules = ['user' => 'required',
				'mail' => 'required|email',
				'sex' => 'required',
				'pref' => 'required',
		];
		$validator=Validator::make($data, $rules);

		if(!$validator->fails()){
			//バリデーションOK
			//データ新規登録時の処理(status=add)
			$form->save();
			$last_id= $form->id;
			$data= Form::whereId($last_id)->get();
			$response = response()->json(array(
					'status' => 'OK',
					'data' => $data[0],
			), 201);
		} else {
			// バリデーションがNGならエラーメッセージを返す
			$message = $validator->messages();
			$response = response()->json(array(
					'status' => 'ERROR',
					'message' => $message
			), 409);
		}
		return $response;
	}

	function setList(){
		return view('test.apisetlist');
	}

	function add(){
		return view('test.apiadd');
	}

	function confirm(Request $request){
		//POSTデータの取得
		$data = $request->all();
		if(!isset($data['sex'])){
			$data['sex']='';
		}

		//セッションに保存
		$request->session()->put($data);

		//バリデーションチェック
		$rules = ['user' => 'required',
				'mail' => 'required|email',
				'sex' => 'required',
				'pref' => 'required',
		];
		$this->validate($request, $rules);

		return view('test.apiconfirm', compact("data"));
	}

	function complete(Request $request){
		//セッションの値を取得
		$data= $request->session()->all();

		//確認画面で「戻る」ボタン押下したときの処理
		if($request->has('back')){
			//入力時の値を入力フォームに引き継ぐ
			//入力フォームでは、oldで値を取得する
			return redirect('api/add')
			->withInput($data);
		}

		//データをPOSTで登録API(addList)に送信
		$url = 'http://localhost/api/addlist';
		$data = array(
				'user' => $data['user'],
				'mail' => $data['mail'],
				'sex' => $data['sex'],
				'pref' => $data['pref'],
		);
		$data = http_build_query($data, "", "&");
		$options = array('http' => array(
				'ignore_errors' => true,
				'method' => 'POST',
				'header' => "Content-type:application/x-www-form-urlencoded\r\nUser-Agent:MyAgent/1.0\r\nContent-Length:" . strlen($data) . "\r\n",
				'content' => $data,
		));
		$options = stream_context_create($options);
		$data= file_get_contents($url, false, $options); //送信結果をJSON形式で取得
		$data= json_decode($data,true); //JSON形式のデータを連想配列に変換
		//ステータスによってページを分岐
		if($data['status']==='OK'){
			return view('test.complete');
		} else {
			return '登録できませんでした。';
		}
	}


}