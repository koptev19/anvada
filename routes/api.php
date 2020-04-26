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

// Список документов, Создание нового документа, Получение документа, Обновление документа
Route::resource('document', 'Api\DocumentController', ['only' => ['index', 'store', 'show', 'update']]);

// Опубликование документа
Route::post('document/{document}/publish', 'Api\DocumentController@publish');

