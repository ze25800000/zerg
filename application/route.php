<?php

use think\Route;

Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');