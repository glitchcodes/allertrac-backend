<?php

if (App::environment('testing')) {
    // Authentication Routes
    Route::prefix('_testing')->group(function () {
        Route::post('/login', function () {

        });
    });
}
