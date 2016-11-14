<?php
namespace App\Http\Controllers\test;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use \App\LogControl;
use App\CustomValidator;

class FormController extends Controller
{

    function index (Request $request)
    {
        // $log->output('debug', 'E10001');
        return view('test.index');
    }

    // ユーザ登録確認画面
    function confirm (Request $request)
    {
        // POSTデータの取得
        $data = $request->all();
        if (! isset($data['sex'])) {
            $data['sex'] = '';
        }

        // セッションに保存
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

    // ユーザ登録完了
    function complete (Request $request)
    {
        // セッションの値を取得
        $data = $request->session()->all();

        // 確認画面で「戻る」ボタン押下したときの処理
        if ($request->has('back')) {
            // 入力時の値を入力フォームに引き継ぐ
            // 入力フォームでは、oldで値を取得する
            return redirect('form')->withInput($data);
        }

        // データ編集時の処理(status=edit)
        if ($request->input('status') === 'edit') {
			$data= ['id'=>$data['id'],
					'user'=>$data['user'],
					'mail'=>$data['mail'],
					'sex'=>$data['sex'],
					'pref'=>$data['pref'],
			];
            DB::update(
                    'update form set user=:user, mail=:mail, sex=:sex, pref=:pref where id=:id',
                    $data);
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

    // ユーザ一覧($itemと$orderで並び替え)
    function userlist ($item = 'id', $order = 'asc')
    {

		$items=['id','user','mail','sex','pref'];
		$orders=['asc','desc'];

        if (in_array($item, $items) && in_array($order, $orders)) {
            $data = DB::table('form')->orderBy($item, $order)->paginate(5); // ページネート処理(5件ごと)
            return view('test.userlist', compact("data"));
        }

        $data = DB::table('form')->orderBy('id', 'asc')->paginate(5); // ページネート処理(5件ごと)
        return view('test.userlist', compact("data"));
    }

    // ユーザ詳細
    function user ($id)
    {
		//formテーブルから該当データを取得する
		$data=DB::select('select * from form where id=:id',['id'=>$id]);
        if (empty($data)) {
            // formテーブルに存在しないid:$idが指定されたとき
            return '該当ユーザのデータはありません。';
        }
        return view('test.user', compact('data'));
    }

    // ユーザ編集
    function edit ($id)
    {
		//formテーブルから編集する該当データを取得する
		$data=DB::select('select * from form where id=:id',['id'=>$id]);
        if (empty($data)) {
            // formテーブルに存在しないid:$idが指定されたとき
            return '該当ユーザのデータはありません。';
        }
        return view('test.edit', compact('data'));
    }

    // ユーザ削除
    function delete (Request $request)
    {
        $data = $request->all();
        // $data= [ 'sex'=>$data['sex'],
        // 'pref'=>$data['pref'],
        // ];

        // 「検索」ボタン押下したときの処理
        // if ($request->has('search')) {
        // $data = DB::select('select * from form where sex=:sex order by id',
        // $data);
        // return view('test.userlist', compact("data"));
        // }

        if ($request->has('delete')) {
            // 削除にチェックが入っていたときだけ処理をする
            foreach ($data as $d) {
				DB::delete('delete from form where id=:id',['id'=>$d]);
            }
            return redirect('/form/userlist');
        }
    }

    // フォームの追加
    function add ()
    {
        return view('test.add');
    }

    function addconfirm(Request $request)
    {
        $data=$request->all();
        //$data['hoge1']=$data['hoge1']-0;
        //return gettype($data['hoge1']);
        $request->session()->put($data);
        //hogecntの値をセッションに保存
        //$request->session()->put('hogecnt',$request->input('hogecnt'));

        //バリデーションチェック
        $rules = [
                'hoge1' => 'required|rangeNumber:0,100|decimal:2',
               // 'total_val'=>'rangeNumber:100,100'
        ];
        for($i=2;$i<=$request->input('hogecnt');$i++){
            $rules['hoge'.$i]='required|rangeNumber:0,100|decimal:2';
        }

        //エラー表示カスタマイズ
        $messages = [
                'hoge1.required'=>'ほげ1を入力してください。',
                'hoge1.range_number'=>'ほげ1には0～100の小数点第2位以下の数値を入力してください。',
                'hoge1.decimal'=>'ほげ1には0～100の小数点第2位以下の数値を入力してください。',
                'total_val.range_number'=>'合計値が100になるように入力してください。'
        ];

        $this->validate($request, $rules, $messages);

        //上のバリデーションを通過後…
        $errmes=$this->check_param($request);
        if(!empty($errmes)){ //エラーがあった場合の処理
            return back()->withInput()->withErrors($errmes);
        }
        return view('test.addconfirm',compact("data"));
    }

    function addcomplete(Request $request)
    {
        //cntの値をセッションに保存
        $request->session()->put('cnt',$request->input('cnt'));
        //セッションの値をすべて取得
        $data=$request->session()->all();

        if($request->has('back')){
            return redirect('form/add')->withInput($data);
        }
    }

    function check_param(Request $request){
        //合計値が100かどうかのチェックとエラーメッセージの作成
        $errmes=[];
        $data= $request->except('hogecnt');
        $total_share=0;
        foreach($data as $key=> $value){
            if(mb_strpos($key,'hoge')===0){
                $total_share+=$value;
            }
        }
        if($total_share!=100){
            $errmes['total_share']='合計値が100になるように入力してください。';
        }
        return $errmes;
    }

    //ajax検索①
    function search(){
        return view('test.search');
    }

    //ajax検索②＃郵便番号
    function zipsearch(){
        return view('test.zipsearch');
    }

    //ファイルアップロード
    //フォーム
    function upfile(){
        return view('test.upfile');
    }

    protected $_filename;
    //アップロード処理
    function upload(Request $request){
        $files = $request->file('files');
        for($i=0;$i<count($files);$i++){
            $this->_filename[$i]='doc_'.date('YmdHis').'_'.$i.'.'.$files[$i]->getClientOriginalExtension();
            $move=$files[$i]->move(dirname(getenv('DOCUMENT_ROOT')).'/storage/doc/',$this->_filename[$i]);
            //session()->put('filename',$this->_filename);
        }
        header('Content-type: text/html');
        echo json_encode($this->_filename);
    }

    function delfile(Request $request){
        $delfile= $request->input('delfile');
        $filepath=dirname(getenv('DOCUMENT_ROOT')).'/storage/doc/'.$delfile;
        if(\File::exists($filepath)){
            if(unlink($filepath)){
                echo 1;exit; // 削除成功
            }else{
                exit; // 削除失敗
            }
        }
    }

    function select(){
        return view('test.select');
    }

    function selectconfirm(Request $request){
        $data= $request->all();
        $request->session()->put($data);
        return redirect('form/select');
    }

    /*function selectconfirm(Request $request){
        $data= $request->all();
        $request['abc']='abcdefg';
        $b=$request->input('abc');
        return 'abc='.$b;
    }*/

    //セッションに保存された値をJSON形式で返す
    function selectjson(){
        $id= session()->get('pulldown');
        echo json_encode(compact("id"));
        return;
    }

    function selectdata(){
        $ret= array(
                '0001'=>'オプション1',
                '0002'=>'オプション2',
                '0003'=>'オプション3'
        );

        $ret= json_encode($ret);
        return $ret;

    }

    function parentwin(){
        return view('test.parentwin');
    }

    function childwin(){
        return view('test.childwin');
    }


    function tablesort(){
        return view('test.tablesort');
    }


}



