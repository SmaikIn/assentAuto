<?php


use App\Domains\Task\Http\Controllers\TaskController;
use App\Domains\User\Http\Controllers\UserController;


Route::post('/tasks/{task}/assign-user', [TaskController::class, 'assignUser']);
Route::post('/tasks/{task}/detach-user', [TaskController::class, 'detachUser']);


Route::group(['prefix' => 'users'], function () {
    Route::post('/{user}', [UserController::class, 'create']);
    Route::put('/{user}', [UserController::class, 'update'])->middleware(['auth']);
    Route::delete('/{user}', [UserController::class, 'delete'])->middleware('auth');
});
/*Route::apiResource('/users', UserController::class)->only(['create', 'update', 'destroy']);*/