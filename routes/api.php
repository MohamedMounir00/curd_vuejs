<?php

Route::resource('posts','PostController',['except'=>['create','edit','show']]);