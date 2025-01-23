<?php

use Core\Router;
use App\Controllers;
Router::get('/', 'NotesController@index');
Router::get('/notes/create','NotesController@create');
Router::post('/notes/create','NotesController@store');
Router::get('/notes/{id}','NotesController@show');
Router::get('/notes/{id}/edit','NotesController@edit');
Router::post('/notes/{id}/edit','NotesController@update');
Router::delete('/notes/{id}/delete','NotesController@delete');
//Router::listRoutes();
$Router = new Router();
$Router->dispatch($_SERVER,$_POST);