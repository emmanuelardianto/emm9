<?php

use Illuminate\Support\Facades\Route;

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
Route::group([
    'namespace' => 'Front',
    'as' => 'front.',
    'middleware' => ['web']
], function ($route) {
    $route->name('home')->get('/', function() {
        return view('layouts.main');
    });
    $route->name('about')->get('/about-me', function() {
        return view('front.about-me');
    });
    $route->name('contact')->get('/contact', function() {
        return view('front.contact');
    });

    $route->name('post')->get('/post', 'PostController@index');
    $route->name('post.archive-page')->get('/archive', 'PostController@archivePage');
    $route->name('post.detail')->get('/post/{post}', 'PostController@show');
    $route->name('post.archive')->get('/archive/{year}/{month}', 'PostController@archive');
    $route->name('post.category')->get('/category/{category}', 'PostController@category');
    $route->name('post.search')->get('/search', 'PostController@search');

    $route->name('collection')->get('/collection', 'CollectionController@index');
    $route->name('collection.show')->get('/collection/{collection}', 'CollectionController@show');

    $route->name('product')->get('/product', 'ProductController@index');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
