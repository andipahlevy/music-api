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

$router->group(['namespace' => 'Eks'], function() use ($router)
{
    
	$router->get('/search/{q}', [
		'as' => 'search', 'uses' => 'HomeController@search'
	]);
	
	$router->get('/playlist/{q}', [
		'as' => 'playlist', 'uses' => 'HomeController@playlist'
	]);	
	
	$router->get('/generate_icon/{title}', [
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
		'as' => 'alias', 'uses' => 'HomeController@alias'
	]);
	$router->get('/myapp', [
		'as' => 'myapp', 'uses' => 'HomeController@myapp'
	]);
	
	
	
});
