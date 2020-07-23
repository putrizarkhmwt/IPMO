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

Route::get('/', 'IPMController@index');
Route::post('/filterbyTahun', 'IPMController@byTahun')->name('filterbyTahun');
Route::get('/segmentasi', 'ClusteringController@getClusterBPS');
Route::get('/normalisasi', 'NormalizationController@getNormalization');
Route::get('/clustering', 'ClusteringController@getCluster');
Route::get('/prediction', 'PredictionController@index');
Route::get('/tren', 'TrendController@index');
Route::get('/tren/{kode}/{wilayah}', 'TrendController@index')->name('trend.filter');
Route::get('/cleaning1', 'CleaningController@handleMissingValue');
Route::get('/cleaning2', 'CleaningController@handleInconsistentData');