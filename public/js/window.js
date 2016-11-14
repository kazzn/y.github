$(function(){

	//子ウィンドウを開く
	$('#search').click(
			function(){
				var subwin;
				subwin=window.open('childwin','subwin','height=200,width=400');
				//子ウィンドウの読み込み完了後に値を設定する
				$(subwin).load(function(){
					var child=subwin.$('#main');
					//データを取得
					var data= [
					           '12345',
					           '15648',
					           '48952'
					           ];
					var html='';
					//ラジオボタンとして表示
					for(i=0;i<data.length;i++){
						html+='<input type="radio" name="sid" id="sid'+i+'" value="'+data[i]+'">';
						html+='<label for="sid'+i+'">'+data[i]+'</label><br/>';
					}
					child.append(html);

				});
			}
	);

	//子ウィンドウの決定ボタンを押したときの処理
	$('#decision').click(
			function(){
				// 親ウィンドウの存在をチェック
				if(!window.opener || window.opener.closed){
					window.alert('メインウィンドウがありません');
					return false;
				}
				//選択値の取得
				var sid;
				sid=$('#main input[name="sid"]:checked').val();
				//親ウィンドウへの値反映
				var parent=opener.$('#sid');
				parent.val(sid);
			}
	);

	//子ウィンドウを閉じる
	$('#close').click(
			function(){
				window.close();
			}
	);





});