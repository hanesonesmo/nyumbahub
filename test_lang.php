<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/lang/sw', 'GET')
);

$request2 = Illuminate\Http\Request::create('/', 'GET');
$request2->setLaravelSession(app('session')->driver());
// wait, testing session across requests manually is annoying
