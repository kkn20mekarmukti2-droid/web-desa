<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dataController;

Route::post('/sinkron', [dataController::class,'sinkron']);
