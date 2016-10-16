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
	<h1>入力フォームの追加(確認)</h1>
	<form action="/form/add/complete" method="POST">

		<table id="formtbl" border="1">
		<?php

		foreach($data as $key => $val){
		    if(mb_strpos($key,'hoge')===0 && !empty($val)){
		        //$keyにhogeを含み、$valに値がセットされている場合
		        $i=mb_substr($key,4,mb_strlen($key)-4);
		?>
		<tr id="item<?= $i ?>">
		<td>項目<?= $i ?>：</td>
		<td>{{ $val }}</td>
		</tr>
		<?php
		    }
		}
		?>
		</table>
		<input type="hidden" name="cnt" value="<?= $i ?>"><!-- 項目がいくつあるかをセット -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="submit" name="back" value="戻る">

	</form>
</body>
</html>
