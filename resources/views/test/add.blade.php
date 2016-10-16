<html>
<head>
<title>Laravel</title>
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapi.com/ajax/libs/jqueryui/1.10.4/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript" src="/js/form.js"></script>
</head>
<body>
	<h1>入力フォームの追加(入力)</h1>
	<form aciton="/form/add" method="POST">
		<table id="formtbl">
		<tr id="item1">
		<td>項目1：</td>
		<td><input type="text" name="hoge1" id="hoge1" value="{{ old('hoge1') }}"></td>
		</tr>
		<?php

		$cnt=old('cnt');
        if($cnt>=2){
            for($i=2;$i<=$cnt;$i++){
                eval("\$val=old('hoge$i');"); //ポイント！
		?>
		<tr id="item<?= $i ?>">
		<td>項目<?= $i ?>：</td>
		<td><input type="text" name="hoge<?= $i ?>" id="hoge<?= $i ?>" value="{{ $val }}"></td>
		</tr>
		<?php
            }
        }
		?>
		</table>

		<input type="button" value="追加" id="add">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="submit" value="送信">
	</form>
</body>
</html>
