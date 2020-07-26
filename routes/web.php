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
		'as' => 'home', 'uses' => 'HomeController@search'
	]);
	$router->get('/playlist/{q}', [
		'as' => 'home', 'uses' => 'HomeController@playlist'
	]);
	
	
	
	
});
