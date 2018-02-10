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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {

// 	$j = file_get_contents('https://whattomine.com/calculators.json');
// 	$j = json_decode($j);
// 	debug($j);
//     return view('welcome');
// });

//Route::get(, ['ResourseDataController@UpWhatToMine', ])->name('site.main.index');

Route::group(['prefix' => '/test','namespace' => 'UploadData'], function() {

	Route::get('/', 'ResourseDataController@UpWhatToMine');

});

Route::get('/math', 'MainController@math');

Route::get('/sum', 'MainController@summary');

Route::get('/gethash', 'MainController@GetCoinsHash');

Route::get('/checkcoins', 'MainController@CheckCoinsAlg');

Route::get('/addvideo', 'MainController@GetAddVideoCard')->name('addvideo');

Route::post('/addvideo', 'MainController@PostAddVideoCard');

Route::get('/index', 'MainController@index')->name('main');

Route::post('/postindex', 'MainController@postindex');

Route::post('/ajax', 'MainController@ajax');

Route::get('/getresours', 'UploadData\ResourseDataController@UpWhatToMine');

Route::get('/getbittrex', 'UploadData\DownBittrexController@downloadPrice');

Route::get('/getyobit', 'UploadData\DownYobitController@downloadPrice');

Route::get('/gethitbtc', 'UploadData\DownHitbtcController@downloadPrice');

Route::get('/getcriptopia', 'UploadData\DownCriptopiaController@downloadPrice');

Route::get('/getprices', 'PriceController@getPrices');