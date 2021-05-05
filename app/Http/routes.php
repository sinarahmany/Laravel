<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/{id}', function ($id) {
    return "this is post number" . $id;
});

/*
|--------------------------------------------------------------------------
| DATABASE RAW SQL QUERIES
|--------------------------------------------------------------------------
*/
Route::get('/insert', function () {
    DB::insert('insert into posts (title, content) values(?,?)' , ['No sleep','Cause learning Laravel']);
});

Route::get('/read', function () {
    $results = DB::select('select * from posts where id = ?' , [1]);
    foreach ($results as $posts){
        return "Title: " . $posts->title . "<br> Content: " . $posts->content;
    }

});

Route::get('/update', function () {
    $updated = DB::update('update posts set title = "this is the new title but still no sleep!" where id = ?' , [1]);
    return $updated;

});

Route::get('/delete', function () {
    $deleted = DB::delete('delete from posts where id = ?' , [3]);
    return $deleted;

});