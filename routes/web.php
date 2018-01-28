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


use Illuminate\Support\Facades\Auth;

Route::get('/','StudentController@index')->name("index");
Route::get('/puzzle','StudentController@indexPuzzle')->name("index_puzzle");
Route::post('/registerstudent','StudentController@register');
Route::post('/registerTeam','StudentController@registerTeam')->name('teams');


Auth::routes();

Route::get('home/single', 'HomeController@indexSingle')->name('home_single');
Route::get('home/team', 'HomeController@indexTeam')->name('home_team');
Route::get('home/singledf/{name}', 'HomeController@name')->name('search_single');
Route::delete('home/single/delete/{id}', 'HomeController@deleteSingle')->name('delete_single');
Route::post('home/single/update','HomeController@updateSingle')->name('update_single');
//Route::post('home/single/getmarks','HomeController@GetMarksSingle')->name('get_marks_single');
Route::post('home/single/updatemarks','HomeController@UpdateMarksSingle')->name('update_marks_single');
Route::post('home/team/update','HomeController@updateTeam')->name('update_team');
//Route::post('home/team/getmarks','HomeController@GetMarksTeam')->name('get_marks_team');
Route::post('home/team/updatemarks','HomeController@UpdateMarksTeam')->name('update_marks_team');
Route::delete('home/team/delete/{id}', 'HomeController@deleteTeam')->name('delete_team');
Route::post('home/single/getAdditional','HomeController@getAdditionalSingle')->name('get_additional_single');
Route::post('home/single/updateAdditional','HomeController@updateAdditionalSingle')->name('update_additional_single');
Route::post('home/team/getAdditional','HomeController@getAdditionalTeam')->name('get_additional_team');
Route::post('home/team/updateAdditional','HomeController@updateAdditionalTeam')->name('update_additional_team');
Route::get('/results','ResultsController@index')->name('results');
Route::post('/generateteam','ResultsController@GenerateResultsTeam')->name('generate_results_team');
Route::post('/generatemath','ResultsController@GenerateResultsMath')->name('generate_results_math');
Route::post('/generatepuzzle','ResultsController@GenerateResultsPuzzle')->name('generate_results_puzzle');
Route::post('/state','ResultsController@ChangeState')->name('state');
Route::post('statePuzzle','ResultsController@ChangePuzzle')->name('state_puzzle');

