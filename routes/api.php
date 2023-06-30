<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LeadController;

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

Route::get('/prova-api', function(){

    $user = [
        'name' => 'Ugo',
        'lastname' => 'de Ughi',
    ];
    $success = true;

    return response()->json(compact('success', 'user'));

});

Route::namespace('Api')
        ->prefix('posts')
        ->group(function(){
            Route::get('/',[PostController::class, 'index']);
            Route::get('/categories',[PostController::class, 'getCategories']);
            Route::get('/tags',[PostController::class, 'getTags']);
            Route::get('/post-category/{id}',[PostController::class, 'getPostsByCategory']);
            Route::get('/post-tag/{id}',[PostController::class, 'getPostsByTag']);
            Route::get('/{slug}',[PostController::class, 'getPostDetail']);
            Route::get('/search/{tosearch}',[PostController::class, 'search']);
        });

Route::post('/contacts', [LeadController::class, 'store'] );
