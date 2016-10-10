<html>
<head>
<title>Laravel</title>
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet'
	type='text/css'>
<style type="text/css">
<!--
table {
	border-collapse: collapse;
}

th, td {
	padding: 3px 5px;
}

th {
	background-color: #eee;
}
-->
</style>
</head>
<body>
	<h1>ユーザ一覧(API)</h1>
	<table border="1">
		<tr>
			<th>削除</th>
			<th>ユーザ名</th>
			<th>メール</th>
			<th>性別</th>
			<th>出身地</th>
			<th>編集</th>
		</tr>
	<?php
	
	// http://localhost/api/getlistからJSONデータを取得
	$data = file_get_contents ( 'http://localhost/api/getlist' );
	$data = mb_convert_encoding ( $data, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN' );
	$data = json_decode ( $data, true );
	
	?>
	@foreach($data as $d)
	<tr>
			<td><input type="checkbox" name="del[]" value="{{ $d['id'] }}"></td>
			<td><a href="javascript:void(0);"
				onclick="window.open('/form/user/{{ $d['id'] }}', 'mywindow1', 'width=400, height=300, menubar=no, toolbar=no, scrollbars=no, location=no');">{{
					$d['user'] }}</a></td>
			<td>{{ $d['mail'] }}</td>
			<td>{{ $d['sex'] }}</td>
			<td>{{ $d['pref'] }}</td>
			<td><a href="/form/edit/{{ $d['id'] }}" target="_target">編集</a></td>
		</tr>
		@endforeach
	</table>



</body>
</html>
