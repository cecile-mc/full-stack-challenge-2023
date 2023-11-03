<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('default');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Routes for Posts
// Route::get('posts', 'PostsController@index');
// Route::post('posts', 'PostsController@store');
// Route::get('posts/create', 'PostsController@create');
// Route::get('posts/{post}', 'PostsController@show');

// Routes for Referrals
Route::middleware('admin')->group(function () {
    Route::get('referrals/upload', 'ReferralController@upload');
    Route::post('referrals/upload', 'ReferralController@processUpload');
});

// users route
Route::get('users', 'AuthorsController@index')->name('users');
Route::get('blocked', function () {
    return view('blocked');
})->name('blocked');
Route::delete('users/{user}/delete', 'AuthorsController@destroy')->name('users.delete');
Route::post('users/{user}/{action}', 'AuthorsController@userStatus')->name('users.status');

Route::get('referrals/create', 'ReferralController@create')->name('add-referral');
Route::get('referrals/{country?}/{city?}', 'ReferralController@index');
Route::post('referrals', 'ReferralController@store');

// comment routes
Route::get('comments/{referral}', 'CommentController@getComments')->name('getComments');
Route::post('comments/', 'CommentController@addComment')->name('addComment');
Route::put('comments', 'CommentController@updateComment')->name('updateComment');

// Logged in Users
Route::get('my-posts', 'AuthorsController@posts')->name('my-posts');


// Routes for Authors
Route::get('authors', 'AuthorsController@index');
Route::get('authors/{author}', 'AuthorsController@show');
