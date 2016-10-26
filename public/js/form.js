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
			//フォームの数をカウント
			$('#hogecnt').val(n);
		}
	);

	function calc_val(i){
		$(document).on(
				"change",
				"#hoge"+i,
				function(){
					n=$('#hogecnt').val();
					if(n===null||n===''){
						n=1;
					}
					total_val=0;
					for(i=1;i<=n;i++){
						total_val+=$('#hoge'+i).val()-0;
					}
					$('#total_val').val(total_val);
				}
		);
	}

	for(i=1;i<=100;i++){
		calc_val(i);
	}



	//フォーム追加②
	$('#addtbl').click(
		function(){
			var body=$('#tbl table:last-child').html();
			var n= $('#tbl table:last-child').attr('id');
			n=n.substr(3,n.length-3)-0+1;
			//テーブルの追加
			$('<table border="1" id="tbl'+n+'"></table>').append(body).appendTo('#tbl');
			//属性の変更
			$('#tbl'+n+' tr:nth-child(1) td').attr('id','data'+n+1);
			$('#tbl'+n+' tr:nth-child(2) td').attr('id','data'+n+2);
			$('#tbl'+n+' tr:nth-child(2) input[type="text"]').attr('name','item'+n);
			$('#tbl'+n+' tr:nth-child(2) input[type="button"]').attr('id','search_btn'+n);
			$('#tbl'+n+' tr:nth-child(2) input[type="button"]').attr('name','search_btn'+n);
			$('#tbl'+n+' tr:nth-child(3) td').attr('id','data'+n+3);
		}
	);

	//フォーム追加③
	$('#addt').click(
			function(){
				var body=$('#tblbox table:last-child tr:last-child').html();
				n= $('#tblbox table:last-child tr:last-child').attr('id');
				n=n.substr(2,n.length-2)-0+1;
				//テーブルの追加
				$('<tr id="tr'+n+'"></tr>').append(body).appendTo('#tblbox table');
				//属性の変更
				$('#tr'+n+' td:nth-child(1) input[type="text"]').attr('id','item'+n+1);
				$('#tr'+n+' td:nth-child(1) input[type="text"]').attr('name','item'+n+1);
				$('#tr'+n+' td:nth-child(1) input[type="button"]').attr('id','sbtn'+n);
				$('#tr'+n+' td:nth-child(1) input[type="button"]').attr('name','sbtn'+n);
				$('#tr'+n+' td:nth-child(2) input[type="text"]').attr('id','item'+n+2);
				$('#tr'+n+' td:nth-child(2) input[type="text"]').attr('name','item'+n+2);
				$('#tr'+n+' td:nth-child(3) input[type="text"]').attr('id','item'+n+3);
				$('#tr'+n+' td:nth-child(3) input[type="text"]').attr('name','item'+n+3);
				$('#tr'+n+' td:nth-child(4) input[type="text"]').attr('id','item'+n+4);
				$('#tr'+n+' td:nth-child(4) input[type="text"]').attr('name','item'+n+4);
			}
		);

	function ev(i){
	   $(document).on(
			"click",
			"#sbtn"+i,
			function(){
				$('#tr'+i+' #item'+i+'2').val('企業名'+i);
				}
			);
	   }

	for(i=1;i<=100;i++){
		ev(i);
	}

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

	//ファイルのアップロード
	$('#files').on("change",function(){
		// ファイル情報を取得
        var files = this.files;
        // FormDataオブジェクトを用意
        var fd = new FormData();
        // ファイルの個数を取得
        var filesLength = files.length;
        // ファイル情報を追加
        for (var i = 0; i < filesLength; i++) {
            fd.append("files[]", files[i]);
        }

		$.ajax({
			//GET,POST,PUT,DELETEなど
			type: 'POST',
			url: '/form/upload',
            data: fd,
            dataType:'json',
            processData: false,
            contentType: false,
            //laravelトークン対策
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
		}).done(function(data,textStatus,jqXHR){
			for(i=0;i<data.length;i++){
				$('#file_list').append('<p id="file'+i+'"><span>'+data[i]+'</span><input type="text" name="attchmnt[]" value="'+data[i]+'"> <input type="button" value="削除"></p>');
			}
			alert('ファイルをアップロードしました。');
		}).fail(function(jqXHR,textStatus,errorThrown){
			//失敗時処理
			alert('ファイルのアップロードに失敗しました。');
		}).always(function(jqXHR,textStatus){
			//共通処理
		});
	});

	//ファイルの削除
	function delfile(i){
	$(document).on(
		"click",
		"#file"+i,
		function(){
			var filename=$('#file'+i+' span').text();
			$.ajax({
				type:"POST",
				url:"/form/delfile",
				data:{
					'delfile':filename
				},
				//laravelトークン対策
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
			}).done(function(data,textStatus,jqXHR){
				$('#file'+i).remove();
				alert('ファイルを削除しました。');
			}).fail(function(jqXHR,textStatus,errorThrown){
				//失敗時処理
				alert('ファイルの削除に失敗しました。');
			}).always(function(jqXHR,textStatus){
				//共通処理
			});

		}
	);
	}

	for(i=0;i<=100;i++){
		delfile(i);
	}







});


