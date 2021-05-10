<?php

use App\Country;
use App\Post;
use App\User;
use App\Role;

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

/*
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

*/

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

//Creating data and configuring mass assignment
Route::get('/create' , function () {
    Post::create(['title'=>'hi i\'m new title' ,'content'=>'and here\'s the new content' ]);
});

Route::get('/update' , function () {
    //Post::where('id',6)->where('is_admin',0)->update(['title'=>'hi i\'m updated title' ,'content'=>'and here\'s the updated content' ]);
    Post::where('id',6)->update(['title'=>'hi i\'m updated title' ,'content'=>'and here\'s the updated content' ]);
});

Route::get('/delete' , function () {
    $post = Post::find(4);
    $post->delete();
    //or

    Post::destroy([4,5]);
});

Route::get('/delete2' , function () {
    Post::where('id',4)->delete();
});

Route::get('/softdelete' , function () {
 Post::find(1)->delete();
});

Route::get('/readsoftdelete' , function () {
    $posts = Post::withTrashed()->where('id',1)->get();
    return $posts;
});

Route::get('/readonlysoftdelete' , function () {
    $posts = Post::onlyTrashed()->where('id',1)->get();
    return $posts;
});

Route::get('/restore' , function () {
    Post::onlyTrashed()->where('id',1)->restore();
});

//delete permanently
Route::get('/forcedelete' , function () {
    Post::withTrashed()->where('id',7)->forceDelete();
});

/*
|--------------------------------------------------------------------------
| ELOQUENT RELATIONSHIPS
|--------------------------------------------------------------------------
*/

//One to one relationship
Route::get('/user/{id}/post' , function($id) {
    return User::find($id)->post;
});

//the field user_id in posts and id in users should exist otherwise it will give an Error!
//Inverse relationship
Route::get('/post/{id}/user' , function($id) {
    return post::find($id)->user->name;
});

//One to many
Route::get('/posts' , function() {
    $user = User::find(1);

    foreach ($user->posts as $post)
    {
    echo $post->title."<br>";
    }
});

//Many to many
Route::get('user/{id}/role' , function ($id){
    $user = User::find($id)->roles()->orderBy('id','desc')->get();
    return $user;

});

//accessing intermediate table /Pivot
Route::get('user/pivot' , function (){
    $user = User::find(1);
    foreach ($user->roles as $role)
    {
        echo $role->pivot->created_at;
    }

});

Route::get('user/country' , function (){
    $country = Country::find(1);
    foreach ($country->posts as $post){
        return $post->title;
    }

});

//Polymorphic relations