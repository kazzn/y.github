<html>
<head>
<title>Laravel</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet'
	type='text/css'>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapi.com/ajax/libs/jqueryui/1.10.4/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript" src="/js/form.js"></script>
<style>
</style>
</head>
<body>

	<h1>ファイルアップロード</h1>
	<div id="file_list">
	</div>
	<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="files" id="files" multiple="multiple">
	</form>
	<input type="button" id="btn" value="ボタンを押す">

</body>
</html>
