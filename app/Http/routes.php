<?php

use App\Post;
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



/*
|--------------------------------------------------------------------------
| ELOQUENT (ORM)
|--------------------------------------------------------------------------
*/

Route::get('/find' , function ()
{

 $posts = Post::all();

 foreach ($posts as $post)
 {
    return $post->title;
 }

});


//find by id
Route::get('/findbyid' , function ()
{
    $post = Post::find(1);
    return $post->title;
});

Route::get('/findwhere' , function () {
    $posts = Post::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
    return $posts;

});

Route::get('/findmore' , function () {
//    $posts = Post::findorFail(10);
//    return $posts;
    $posts = Post::where('users_count','<',50)->firstorFail();
});

Route::get('/basicinsert' , function () {
    $post = new Post;
    $post->title = 'New Eloquent title';
    $post->content = 'Laravel made it so easy!';
    $post->save();
});

Route::get('/basicupdate' , function () {
    $post = Post::find(1);
    $post->title = 'New Eloquent title';
    $post->content = 'Laravel made it so easy!';
    $post->save();
});
