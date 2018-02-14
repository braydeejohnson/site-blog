<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return view('posts');
});

Route::get('{slug}', function(){
	return view('post', [
		'body' =>   Markdown::parse(File::get(storage_path('/app/posts/test.md')))
	]);
});