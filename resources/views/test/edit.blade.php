<html>
<head>
<title>Laravel</title>
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet'
	type='text/css'>
<style>
</style>
</head>
<body>
	<h1>入力フォーム</h1>
	<form action="/form" method="POST">

		@foreach($data as $d)

		<p>
			<label for="user">ユーザ名：</label><input type="text" name="user"
				id="user" value="{{ $d->user }}"><br /> @if($errors->has('user'))<span
				class="error">{{ $errors->first('user') }}</span> @endif
		</p>

		<p>
			<label for="mail">メール：</label><input type="text" name="mail"
				id="mail" value="{{ $d->mail }}"><br /> @if($errors->has('mail'))<span
				class="error">{{ $errors->first('mail') }}</span> @endif
		</p>

		<p>
			性別：<input type="radio" name="sex" id="male" value="男性" @if($d->sex==='男性')
			checked @endif><label for="male">男性</label> <input type="radio"
				name="sex" id="female" value="女性" @if($d->sex==='女性') checked
			@endif><label for="female">女性</label><br /> @if($errors->has('sex'))<span
				class="error">{{ $errors->first('sex') }}</span> @endif
		</p>


	<?php
	//出身地の選択肢
	$prefs=['北海道','東北','北信越','関東','東海','近畿','中国','四国','九州'];
?>
	<p>
			<label for="pref">出身地：</label> <select name="pref">
				<option value="">選択してください</option> @foreach($prefs as $pref)
				<option value="{{ $pref }}" @if($d->pref===$pref) selected @endif>{{
					$pref }}</option> @endforeach
			</select><br /> @if($errors->has('pref'))<span class="error">{{
				$errors->first('pref') }}</span> @endif
		</p>
		@endforeach
		<!-- statusにeditをセット -->
		<input type="hidden" name="status" value="edit"> <input type="hidden"
			name="_token" value="{{ csrf_token() }}"> <input type="submit"
			value="送信">
	</form>
</body>
</html>
