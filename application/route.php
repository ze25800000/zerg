<?php

use think\Route;

Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');