<?php

namespace App\Http\Controllers\test;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;

class FormController extends Controller {

	function index(Request $request){
		return view('test.index');
	}

	//ユーザ登録確認画面
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

		return view('test.confirm', compact("data"));
	}

	//ユーザ登録完了
	function complete(Request $request){
		//セッションの値を取得
		$data = $request->session()->all();

		//確認画面で「戻る」ボタン押下したときの処理
		if($request->has('back')){
			//入力時の値を入力フォームに引き継ぐ
			//入力フォームでは、oldで値を取得する
			return redirect('form')
			->withInput($data);
		}

		//データ編集時の処理(status=edit)
		if($request->input('status')==='edit'){
			$data= ['id'=>$data['id'],
					'user'=>$data['user'],
					'mail'=>$data['mail'],
					'sex'=>$data['sex'],
					'pref'=>$data['pref'],
			];
			DB::update('update form set user=:user, mail=:mail, sex=:sex, pref=:pref where id=:id',$data);
			return '編集しました。';
		}

		//データ新規登録時の処理(status=add)
		DB::table('form')->insert([
				'user'=> $data['user'],
				'mail'=> $data['mail'],
				'sex'=> $data['sex'],
				'pref'=> $data['pref'],
		]);
		return view('test.complete');
	}

	//ユーザ一覧($itemと$orderで並び替え)
	function userlist($item='id',$order='asc'){

		$items=['id','user','mail','sex','pref'];
		$orders=['asc','desc'];

		if(in_array($item,$items)&&in_array($order,$orders)){
			$data= DB::table('form')->orderBy($item,$order)->paginate(5); //ページネート処理(5件ごと)
			return view('test.userlist',compact("data"));
		}

		$data= DB::table('form')->orderBy('id','asc')->paginate(5); //ページネート処理(5件ごと)
		return view('test.userlist',compact("data"));
	}

	//ユーザ詳細
	function user($id){
		//formテーブルから該当データを取得する
		$data=DB::select('select * from form where id=:id',['id'=>$id]);
		if(empty($data)){
			//formテーブルに存在しないid:$idが指定されたとき
			return '該当ユーザのデータはありません。';
		}
		return view('test.user',compact('data'));
	}

	//ユーザ編集
	function edit($id){
		//formテーブルから編集する該当データを取得する
		$data=DB::select('select * from form where id=:id',['id'=>$id]);
		if(empty($data)){
			//formテーブルに存在しないid:$idが指定されたとき
			return '該当ユーザのデータはありません。';
		}
		return view('test.edit',compact('data'));
	}

	//ユーザ削除
	function delete(Request $request){
		$data= $request->input('del');
		if(!empty($data)){
			//削除にチェックが入っていたときだけ処理をする
			foreach($data as $d){
				DB::delete('delete from form where id=:id',['id'=>$d]);
			}
		}
		return redirect('/form/userlist');
	}


}



