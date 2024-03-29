<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
	ceck version //return $router->app->version();
*/
$router->get('/', function(){
	echo 'Website is under construction. Contact me <a href="mailto:andilevi@gmail.com">Email</a>';die;
});

$router->group(['namespace' => 'Eks'], function() use ($router)
{

	$router->get('/search/{q}', [
		'as' => 'search', 'uses' => 'HomeController@search'
	]);

	$router->get('/playlist/{q}', [
		'as' => 'playlist', 'uses' => 'HomeController@playlist'
	]);

	$router->get('/gdrive', [
		'as' => 'gdrive', 'uses' => 'HomeController@gdrive'
	]);

	$router->post('/upload', [
		'as' => 'upload', 'uses' => 'HomeController@post_gdrive'
	]);

	$router->post('/post_gdrive_unlimited', [
		'as' => 'post_gdrive_unlimited', 'uses' => 'HomeController@post_gdrive_unlimited'
	]);

	$router->get('/gdrive_find/', [
		'as' => 'gdrive_find', 'uses' => 'HomeController@gdrive_find'
	]);

	$router->post('/gdrive_find2/', [
		'as' => 'gdrive_find2', 'uses' => 'HomeController@gdrive_find2'
	]);

	$router->post('/gdrive_list_by_folder/', [
		'as' => 'gdrive_list_by_folder', 'uses' => 'HomeController@gdrive_list_by_folder'
	]);

	$router->get('/send_mail', [
		'as' => 'send_mail', 'uses' => 'HomeController@send_mail'
	]);


	/*START GENERATE PLAYSTORE ASSET*/
	$router->get('/generate_icon/{title}/{subtitle}', [
		'as' => 'generate_icon', 'uses' => 'HomeController@generate_icon'
	]);
	$router->get('/generate_banner', [
		'as' => 'generate_banner', 'uses' => 'HomeController@generate_banner'
	]);
	$router->get('/generate_ss', [
		'as' => 'generate_ss', 'uses' => 'HomeController@generate_ss'
	]);
	$router->get('/generate_desc', [
		'as' => 'generate_desc', 'uses' => 'HomeController@generate_desc'
	]);
	$router->get('/generate_all', [
		'as' => 'generate_all', 'uses' => 'HomeController@generate_all'
	]);
	$router->get('/cache/clear', [
		'as' => 'cache.clear', 'uses' => 'CacheController@clear'
	]);
	$router->get('/urlalias', [
		'as' => 'urlalias', 'uses' => 'HomeController@urlalias'
	]);
	$router->get('/alias/{url}', [
		'as' => 'alias', 'uses' => 'CacheController@alias'
	]);
	$router->get('/myapp', [
		'as' => 'myapp', 'uses' => 'HomeController@myapp'
	]);
});
$router->group(['prefix' => 'v2','namespace' => 'V2'], function() use ($router)
{

	$router->get('/search/{q}', [
		'as' => 'search', 'uses' => 'HomeController@search'
	]);

	$router->get('/playlist/{q}', [
		'as' => 'playlist', 'uses' => 'HomeController@playlist'
	]);

	$router->get('/gdrive', [
		'as' => 'gdrive', 'uses' => 'HomeController@gdrive'
	]);

	$router->get('/cekClient', [
		'as' => 'gdrive', 'uses' => 'HomeController@cekClient'
	]);

	$router->post('/upload', [
		'as' => 'upload', 'uses' => 'HomeController@post_gdrive'
	]);

	$router->post('/post_gdrive_unlimited', [
		'as' => 'post_gdrive_unlimited', 'uses' => 'HomeController@post_gdrive_unlimited'
	]);

	$router->get('/gdrive_find/', [
		'as' => 'gdrive_find', 'uses' => 'HomeController@gdrive_find'
	]);

	$router->post('/gdrive_find2/', [
		'as' => 'gdrive_find2', 'uses' => 'HomeController@gdrive_find2'
	]);

	$router->post('/gdrive_list_by_folder/', [
		'as' => 'gdrive_list_by_folder', 'uses' => 'HomeController@gdrive_list_by_folder'
	]);

	$router->get('/send_mail', [
		'as' => 'send_mail', 'uses' => 'HomeController@send_mail'
	]);


	/*START GENERATE PLAYSTORE ASSET*/
	$router->get('/generate_icon/{title}/{subtitle}', [
		'as' => 'generate_icon', 'uses' => 'HomeController@generate_icon'
	]);
	$router->get('/generate_banner', [
		'as' => 'generate_banner', 'uses' => 'HomeController@generate_banner'
	]);
	$router->get('/generate_ss', [
		'as' => 'generate_ss', 'uses' => 'HomeController@generate_ss'
	]);
	$router->get('/generate_desc', [
		'as' => 'generate_desc', 'uses' => 'HomeController@generate_desc'
	]);
	$router->get('/generate_all', [
		'as' => 'generate_all', 'uses' => 'HomeController@generate_all'
	]);
	$router->get('/cache/clear', [
		'as' => 'cache.clear', 'uses' => 'CacheController@clear'
	]);
	$router->get('/urlalias', [
		'as' => 'urlalias', 'uses' => 'HomeController@urlalias'
	]);
	$router->get('/alias/{url}', [
		'as' => 'alias', 'uses' => 'CacheController@alias'
	]);
	$router->get('/myapp', [
		'as' => 'myapp', 'uses' => 'HomeController@myapp'
	]);
});
$router->group(['prefix' => 'v3','namespace' => 'V3'], function() use ($router)
{
//    Harap baca di server ini diganti -> vim vendor/alaouy/youtube/src/YoutubeServiceProvider.php

	$router->get('/search/{q}', [
		'as' => 'search', 'uses' => 'HomeController@search'
	]);

	$router->get('/playlist/{q}', [
		'as' => 'playlist', 'uses' => 'HomeController@playlist'
	]);

	$router->get('/gdrive', [
		'as' => 'gdrive', 'uses' => 'HomeController@gdrive'
	]);

	$router->post('/upload', [
		'as' => 'upload', 'uses' => 'HomeController@post_gdrive'
	]);

	$router->post('/post_gdrive_unlimited', [
		'as' => 'post_gdrive_unlimited', 'uses' => 'HomeController@post_gdrive_unlimited'
	]);

	$router->get('/gdrive_find/', [
		'as' => 'gdrive_find', 'uses' => 'HomeController@gdrive_find'
	]);

	$router->post('/gdrive_find2/', [
		'as' => 'gdrive_find2', 'uses' => 'HomeController@gdrive_find2'
	]);

	$router->post('/gdrive_list_by_folder/', [
		'as' => 'gdrive_list_by_folder', 'uses' => 'HomeController@gdrive_list_by_folder'
	]);

	$router->get('/send_mail', [
		'as' => 'send_mail', 'uses' => 'HomeController@send_mail'
	]);


	/*START GENERATE PLAYSTORE ASSET*/
	$router->get('/generate_icon/{title}/{subtitle}', [
		'as' => 'generate_icon', 'uses' => 'HomeController@generate_icon'
	]);
	$router->get('/generate_banner', [
		'as' => 'generate_banner', 'uses' => 'HomeController@generate_banner'
	]);
	$router->get('/generate_ss', [
		'as' => 'generate_ss', 'uses' => 'HomeController@generate_ss'
	]);
	$router->get('/generate_desc', [
		'as' => 'generate_desc', 'uses' => 'HomeController@generate_desc'
	]);
	$router->get('/generate_desc_java', [
		'as' => 'generate_desc_java', 'uses' => 'HomeController@generate_desc_java'
	]);
	$router->get('/generate_all', [
		'as' => 'generate_all', 'uses' => 'HomeController@generate_all'
	]);
	$router->get('/cache/clear', [
		'as' => 'cache.clear', 'uses' => 'CacheController@clear'
	]);
	$router->get('/urlalias', [
		'as' => 'urlalias', 'uses' => 'HomeController@urlalias'
	]);
	$router->get('/alias/{url}', [
		'as' => 'alias', 'uses' => 'CacheController@alias'
	]);
	$router->get('/myapp', [
		'as' => 'myapp', 'uses' => 'HomeController@myapp'
	]);
});
