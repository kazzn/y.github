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
	<?php $user=Auth::user(); ?>
	<p>
		ようこそ{{ $user->name }}さん <a href="/auth/logout">ログアウト</a>
	</p>
	<h1>ユーザ一覧</h1>
	<form method="POST" action="/form/userlist">
		<input type="submit" name="delete" value="削除"> <a href="/form"
			target="_blank">登録</a>
		<table border="1">
			<tr>
				<th>削除</th>
				<th>ユーザ名<a href="/form/userlist/user/asc">▲</a><a
					href="/form/userlist/user/desc">▼</a></th>
				<th>メール</th>
				<th>性別</th>
				<th>出身地</th>
				<th>編集</th>
			</tr>
			@foreach($data as $d)
			<tr>
				<td><input type="checkbox" name="del[]" value="{{ $d->id }}"></td>
				<td><a href="javascript:void(0);"
					onclick="window.open('/form/user/{{ $d->id }}', 'mywindow1', 'width=400, height=300, menubar=no, toolbar=no, scrollbars=no, location=no');">{{
						$d->user }}</a></td>
				<!-- td><a href="/form/user/{{ $d->id }}" target="_target">{{ $d->user }}</a></td-->
				<td>{{ $d->mail }}</td>
				<td>{{ $d->sex }}</td>
				<td>{{ $d->pref }}</td>
				<td><a href="/form/edit/{{ $d->id }}" target="_target">編集</a></td>
			</tr>
			@endforeach
		</table>
		<!-- ページコントロール -->
		{!! $data->render() !!} <input type="hidden" name="_token"
			value="{{ csrf_token() }}">
	</form>

</body>
</html>
