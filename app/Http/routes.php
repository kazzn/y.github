<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get('/', 'WelcomeController@index');
// a
Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('lalabel/{user}', 'HelloController@index');

/*
 * ユーザ管理アプリ
 */
// 認証
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 登録
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//ユーザ管理
//'middleware'=>'auth'で認証が必要なページに認証済みかのチェックを行う。非認証の場合はログインページにリダイレクトされる。
//usesはどのコントローラーを使用するかを指定する。
Route::get('form', ['middleware'=>'auth', 'uses'=>'test\FormController@index']);
Route::post('form', 'test\FormController@confirm');
Route::post('form/complete', 'test\FormController@complete');
Route::get('form/userlist/{item?}/{order?}', ['middleware'=>'auth', 'uses'=>'test\FormController@userlist']);
// Route::get('form/userlist', 'test\FormController@userlist');
Route::post('form/userlist', 'test\FormController@delete');
Route::get('form/user/{id}', 'test\FormController@user');
Route::get('form/edit/{id}', 'test\FormController@edit');
//フォームの追加
Route::get('form/add', 'test\FormController@add');
Route::post('form/add','test\FormController@addconfirm');
Route::post('form/add/complete', 'test\FormController@addcomplete');
//APIajax検索
Route::get('form/search', 'test\FormController@search');
Route::get('form/zipsearch','test\FormController@zipsearch');


/*
 * API活用
 */
Route::get('api/getlist/{id?}', 'test\APIController@getList');
Route::get('api/setlist', 'test\APIController@setList');
Route::get('api/add', 'test\APIController@add');
Route::post('api/add', 'test\APIController@confirm');
Route::post('api/complete', 'test\APIController@complete');
Route::post('api/addlist', 'test\APIController@addList');

//ファイルアップロード
Route::get('form/upfile','test\FormController@upfile');
Route::post('form/upload','test\FormController@upload');
Route::post('form/delfile','test\FormController@delfile');






