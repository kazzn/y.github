<html>
<head>
<title>Laravel</title>
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapi.com/ajax/libs/jqueryui/1.10.4/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript" src="/js/form.js"></script>
<style type="text/css">
<!--

.error {
    background-color:#ffc1f9;
    }

 --></style>


</head>
<body>

	<h1>入力フォームの追加(入力)</h1>

	<ul>{{ $errors->first('total_val') }}</ul>
	<p>{{ $errors->first('total_share') }}</p>
	<form action="/form/add" method="POST">
		<table id="formtbl">
		<tr id="item1">
		<td>項目1：</td>
		<td><input type="text" name="hoge1" id="hoge1" value="{{ old('hoge1') }}" class={{ $errors->has('hoge1') ? 'error' : '' }}>{{ $errors->first('hoge1') }}</td>
		</tr>
		<?php

		$cnt=old('hogecnt');
        if($cnt>=2){
            for($i=2;$i<=$cnt;$i++){
                eval("\$val=old('hoge$i');"); //ポイント！
                eval("\$class=\$errors->has('hoge$i')?'error':'';"); //ポイント！
		?>
		<tr id="item<?= $i ?>">
		<td>項目<?= $i ?>：</td>
		<td><input type="text" name="hoge<?= $i ?>" id="hoge<?= $i ?>" value="{{ $val }}" class="{{ $class }}"></td>
		</tr>
		<?php
            }
        }
		?>
		</table>
		<input type="text" id="total_val" name="total_val" value="{{ old('total_val') }}">
		<input type="button" value="追加" id="add"><input type="text" id="hogecnt" name="hogecnt" value="{{ $cnt }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="submit" value="送信">
	</form>

	<div id="tbl">
	<table border="1" id="tbl1">
	<tr>
	<th>項目1</th>
	<td id="data11"></td>
	</tr>
	<tr>
	<th>項目2</th>
	<td id="data12"><input type="text" name="item1"> <input type="button" name="search_btn1" id="search_btn1" value="検索"></td>
	</tr>
	<tr>
	<th>項目3</th>
	<td id="data13"></td>
	</tr>
	</table>
	</div>
	<input type="button" value="追加する" id="addtbl">


	<div id="tblbox">
	<table border="1">
	<tr>
	<th>項目1</th>
	<th>項目2</th>
	<th>項目3</th>
	<th>項目4</th>
	</tr>
	<tr id="tr1">
	<td><input type="text" name="item11" id="item11"> <input type="button" name="search_btn1" id="sbtn1" value="検索"></td>
	<td><input type="text" name="item12" id="item12"></td>
	<td><input type="text" name="item13" id="item13"></td>
	<td><input type="text" name="item14" id="item14"></td>
	</tr>
	</table>
	</div>
	<input type="button" value="追加する" id="addt">

</body>
</html>
