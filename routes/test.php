<?php
use Illuminate\Support\Facades\Route;

Route::post('/test-upload', function () {
    return "Success";
})->middleware(['web', 'auth']);

Route::get('/test-upload', function () {
    return '<form method="POST" action="/test-upload" enctype="multipart/form-data">'.csrf_field().'<input type="file" name="file"><button type="submit">Upload</button></form>';
})->middleware(['web', 'auth']);
