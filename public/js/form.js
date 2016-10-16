$(function(){

	//フォーム追加
	$('#add').click(
		function(){
			var td=$('#formtbl tr:last-child').html();
			var n=$('#formtbl tr:last-child').attr('id');
			n=n.substr(4,n.length-4)-0+1;
			//フォームの最後の要素をコピー
			$('#formtbl').append('<tr id="item'+n+'">'+td+'</tr>');
			//項目名を変更
			$('#item'+n+' td:first-child').text('項目'+n+'：');
			//属性を変更、値を初期化
			$('#item'+n+' input').attr('name','hoge'+n).attr('id','hoge'+n).val('');
		}
	);

	//ajax検索①
	$('#search').click(
		function() {

			//検索idの取得
			var id=$('#id').val();

			//検索結果表示の初期化
			$('#list').empty();

			$.ajax({
				// リクエストメソッド(GET,POST,PUT,DELETEなど)
				type: 'GET',
				// リクエストURL
				url: '/api/getlist/'+id,
				// タイムアウト(ミリ秒)
				timeout: 10000,
				// サーバに送信するデータ(name: value)
			    /*data: {
			      'param1': 'ほげ',
			      'foo': 'データ'
			    },*/
				// レスポンスを受け取る際のMIMEタイプ(html,json,jsonp,text,xml,script)
			    // レスポンスが適切なContentTypeを返していれば自動判別する。
				dataType: 'json'
			}).done(function( data, textStatus, jqXHR ) {
				// 成功時処理
				var list='';
				if(data['status']==='NG'||isNaN(id)){
					list='<li>データが存在しません。</li>';
				} else {
					for(i=0;i<data['data'].length;i++){
						list += '<li>';
						for(key in data['data'][i]){
							list += data['data'][i][key];
						}
						list += '</li>';
					}
				}
				$('#list').append(list);
			})
			.fail(function( jqXHR, textStatus, errorThrown ) {
				// 失敗時処理
				window.alert('NG');
			}).always(function(jqXHR, textStatus) {
			    // doneまたはfail実行後の共通処理
			});
		}
	);

	$('#zipsearch').click(function(){
		//入力値の取得
		zipcode=$('#zipcode').val();
		//結果表示の初期化
		$('#zipresult').empty();
		//Loadingイメージ表示
		dispLoading();

		$.ajax({
			//GET,POST,PUT,DELETEなど
			type: 'GET',
			url: 'http://zipcloud.ibsnet.co.jp/api/search',
			data: {
				zipcode: zipcode
			},
			//データ形式(json,jsonp,xmlなど)
			dataType: 'jsonp',
			//jsonp形式時のコールバック関数
			jsonpCallback: 'zipsearch',
			timeout: 10000
		}).done(function(data,textStatus,jqXHR){
			//成功時処理
			if(data['status']===200){
				//正常時処理
				if(data['results']!==null){
					result=data['results'][0]['address1']+data['results'][0]['address2']+data['results'][0]['address3'];
				} else {
					result='データが存在しません。';
				}
			} else {
				result='データの取得に失敗しました。';
			}
			$('#zipresult').append(result);
		}).fail(function(jqXHR,textStatus,errorThrown){
			//失敗時処理
			$('#zipresult').append('通信中にエラーが発生しました。');
		}).always(function(jqXHR,textStatus){
			//共通処理
			// Loadingイメージを削除
	        removeLoading();
		});

	});

	// Loadingイメージ表示関数
	function dispLoading(msg){
	    // ローディング画像が表示されていない場合のみ表示
	    if($("#loading").size() == 0){
	        $("#zipresult").append("<div id='loading'></div>");
	    }
	}

	// Loadingイメージ削除関数
	function removeLoading(){
		$("#loading").remove();
	}

});


