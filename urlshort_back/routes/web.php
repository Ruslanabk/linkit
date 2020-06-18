<?php

use App\User;
use App\Link;
use Illuminate\Http\Request;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| routerlication Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an routerlication.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function (){
    return "Welcome to my revolution url shortener! :D";
});
$router->get('/register', 'UsersController@register');

$router->group(['prefix' => 'api'], function ($router) {
    $router->get('/login', 'UsersController@authenticate');
    $router->get('/link', 'LinksController@index');
    $router->post('/link', 'LinksController@store');
    $router->get('/link/{id}/', 'LinksController@show');
    $router->put('/link/{id}/', 'LinksController@update');
    $router->delete('/link/{id}/', 'LinksController@destroy');
});

$router->get('/{user}/{route}', function ($user, $route, Request $request){
    $user = User::where('username', $user)->first();
    $link = Link::where('user_id', $user->id)->where('route', $route)->first();
    // var_dump($user->id);
    // var_dump($link->url);
    
    // header("HTTP/1.1 301 Moved Permanently");
    // header("Location: ".$link->url);
    return redirect()->away($link->url); 
});
