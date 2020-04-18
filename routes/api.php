<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Создание нового документа
Route::post('document', 'Api\DocumentController@store');

// Получение одного документа
Route::get('document/{document}', 'Api\DocumentController@one');

// Обновление документа
Route::patch('document/{document}', 'Api\DocumentController@update');

// Опубликование документа
Route::post('document/{document}/publish', 'Api\DocumentController@publish');

// Список документов с пагинацией
Route::get('document', 'Api\DocumentController@show');
