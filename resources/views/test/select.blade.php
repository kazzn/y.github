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

	<h1>プルダウンリスト</h1>

	<form action="select" method="POST">
	<input type="button" id="search" value="検索">
	<select name="pulldown" id="pulldown">
	<option>選択してください。</option>
	</select>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="送信">
	</form>



</body>
</html>
