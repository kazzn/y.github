<html>
	<head>
		<title>Laravel</title>
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<style>
		</style>
	</head>
	<body>
	<h1>確認フォーム</h1>
	<form action="complete" method="POST">
	<p>ユーザ名：{{ $data['user'] }}</p>
	<p>メール：{{ $data['mail'] }}</p>
	<p>性別：{{ $data['sex'] }}</p>
	<p>出身地：{{ $data['pref']}}</p>
	<!-- statusで新規登録か編集か処理を分岐する -->
	<input type="hidden" name="status" value="{{ $data['status'] }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" name="back" value="戻る">　<input type="submit" value="送信">
	</form>
	</body>
</html>
