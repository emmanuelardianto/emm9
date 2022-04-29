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
    $route->name('home')->get('/', 'HomeController@index');
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

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'ura',
    'as' => 'admin.',
    'middleware' => ['web', 'auth']
], function ($route) {
    $route->name('post.index')->get('/post', 'PostController@index');
    $route->name('post.create')->get('/post/create', 'PostController@create');
    $route->name('post.store')->post('/post/create', 'PostController@store');
    $route->name('post.show')->get('/post/{post}', 'PostController@show');
    $route->name('post.edit')->get('/post/{post}/edit', 'PostController@edit');
    $route->name('post.update')->post('/post/{post}/edit', 'PostController@store');
    $route->name('post.image-upload')->post('/image-upload/', 'PostController@image_upload');

    $route->name('photo.index')->get('/photo', 'PhotoController@index');
    $route->name('photo.create')->get('/photo/create', 'PhotoController@create');
    $route->name('photo.store')->post('/photo/create', 'PhotoController@store');
    $route->name('photo.show')->get('/photo/{photo}', 'PhotoController@show');

    $route->name('tag')->get('/tag', 'TagController@index');
    $route->name('subscription')->get('/subscription', 'SubscriptionController@index');

    $route->name('product')->get('/product', 'ProductController@index');
    $route->name('product.create')->get('/product/create', 'ProductController@create');
    $route->name('product.store')->post('/product/create', 'ProductController@store');
    $route->name('product.show')->get('/product/{product}', 'ProductController@show');
    $route->name('product.edit')->get('/product/{product}/edit', 'ProductController@edit');
    $route->name('product.update')->post('/product/{product}/edit', 'ProductController@store');
    $route->name('product.gallery')->get('/product/{product}/image-upload/', 'ProductController@gallery');
    $route->name('product.gallery.store')->post('/product/{product}/image-upload/', 'ProductController@galleryUpdate');
    $route->name('product.gallery.delete')->post('/product/{product}/delete/{index}', 'ProductController@galleryDelete');

    $route->name('collection')->get('/collection', 'CollectionController@index');
    $route->name('collection.create')->get('/collection/create', 'CollectionController@create');
    $route->name('collection.store')->post('/collection/create', 'CollectionController@store');
    $route->name('collection.show')->get('/collection/{collection}', 'CollectionController@show');
    $route->name('collection.edit')->get('/collection/{collection}/edit', 'CollectionController@edit');
    $route->name('collection.update')->post('/collection/{collection}/edit', 'CollectionController@store');

});

// Auth::routes();

Route::get('/ura/login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('/ura/login', [
'as' => '',
'uses' => 'Auth\LoginController@login'
]);
Route::post('/ura/logout', [
'as' => 'logout',
'uses' => 'Auth\LoginController@logout'
]);