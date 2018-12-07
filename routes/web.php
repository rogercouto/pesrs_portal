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

Route::get('/', 'PortalController@index')->name('main');
Route::get('/posts/{id}', 'PortalController@showPost')->name('post');
Route::get('/pages/{id}', 'PortalController@showPage')->name('page');
Route::post('/find', 'PortalController@findPost')->name('find');
Route::get('/results/{text}', 'PortalController@showResults')->name('results');
Route::get('/tags/{id}', 'PortalController@showTag')->name('tag');
Route::post('/tags', 'PortalController@findTag')->name('tags');
Route::get('/tags/{id}', 'PortalController@showTag')->name('tag');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/messages/send', 'Adm\MessageController@send')->name('messages.send');

Auth::routes();

Route::group(['prefix' => 'adm', 'middleware' => 'auth'], function (){

    Route::get('/welcome', 'Adm\WelcomeController@index')->name('welcome');

    Route::resource('posts', 'Adm\PostController');

    Route::delete('/posts/{id}/image/destroy', 'Adm\PostController@destroyImage')->name('posts.image.destroy');
    Route::get('/posts/{id}/banner/upload', 'Adm\PostController@uploadBanner');
    Route::post('/posts/{id}/banner/upload', 'Adm\PostController@storeBanner')->name('posts.banner.upload');
    Route::delete('/posts/{id}/banner/destroy', 'Adm\PostController@destroyBanner')->name('posts.banner.destroy');
    Route::post('/posts/{id}/banner/setdate', 'Adm\PostController@setBannerDate')->name('posts.banner.setdate');
    Route::post('/posts/{id}/file/upload', 'Adm\PostController@uploadFile')->name('posts.file.upload');
    Route::post('/posts/{id}/photo/upload', 'Adm\PostController@uploadPhoto')->name('posts.photo.upload');
    Route::delete('/posts/file/{id}/delete', 'Adm\PostController@deleteFile')->name('posts.file.delete');
    Route::delete('/posts/photo/{id}/delete', 'Adm\PostController@deletePhoto')->name('posts.photo.delete');
    Route::put('/posts/{id}/publish', 'Adm\PostController@publish')->name('posts.publish');

    Route::resource('tags', 'Adm\TagController');

    Route::resource('pages', 'Adm\PageController');
    Route::post('/pages/{id}/file/upload', 'Adm\PageController@uploadFile')->name('pages.file.upload');
    Route::post('/pages/{id}/photo/upload', 'Adm\PageController@uploadPhoto')->name('pages.photo.upload');
    Route::delete('/pages/file/{id}/delete', 'Adm\PageController@deleteFile')->name('pages.file.delete');
    Route::delete('/pages/photo/{id}/delete', 'Adm\PageController@deletePhoto')->name('pages.photo.delete');

    Route::resource('menus', 'Adm\MenuItemController');
    Route::put('/menus/{id}/up', 'Adm\MenuItemController@up')->name('menus.up');
    Route::put('/menus/{id}/down', 'Adm\MenuItemController@down')->name('menus.down');

    Route::get('/messages', 'Adm\MessageController@index')->name('messages');
    Route::get('/messages/{id}', 'Adm\MessageController@show')->name('messages.show');
    Route::get('/messages/{id}/read', 'Adm\MessageController@read')->name('messages.read');
    Route::put('/messages/{id}/setreaded', 'Adm\MessageController@setReaded')->name('messages.setreaded');
    Route::put('/messages/{id}/setanswered', 'Adm\MessageController@setAnswered')->name('messages.setanswered');
    Route::post('/messages/{id}/answer', 'Adm\MessageController@answer')->name('messages.answer');
});
