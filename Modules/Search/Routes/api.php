<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Search\Http\Controllers\Api\SearchController;

Route::get('search', [SearchController::class, 'search']);
