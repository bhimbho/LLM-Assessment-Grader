<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('/assignments', App\Http\Controllers\AssignmentController::class);