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
	<h1>ユーザ詳細</h1>
	<table border="1">
		@foreach($data as $d)
		<tr>
			<th>ユーザ名</th>
			<td>{{ $d->user }}</td>
		</tr>
		<tr>
			<th>メール</th>
			<td>{{ $d->mail }}</td>
		</tr>
		<tr>
			<th>性別</th>
			<td>{{ $d->sex }}</td>
		</tr>
		<tr>
			<th>出身地</th>
			<td>{{ $d->pref }}</td>
		</tr>
		@endforeach
	</table>








</body>
</html>
