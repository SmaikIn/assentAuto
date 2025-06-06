<?php


use App\Domains\Task\Http\Controllers\TaskController;


Route::group(['prefix' => 'tasks'], function () {
    Route::post('/{task}', [TaskController::class, 'create']);
    Route::put('/{task}', [TaskController::class, 'update']);
    Route::delete('/{task}', [TaskController::class, 'delete']);

    Route::post('/{task}/assign-user', [TaskController::class, 'assignUser']);
    Route::post('/{task}/detach-user', [TaskController::class, 'detachUser']);
});
/*Route::apiResource('/tasks', UserController::class)->only(['create', 'update', 'destroy']);*/