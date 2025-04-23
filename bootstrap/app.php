<?php

use Illuminate\Foundation\Application;

return Application::configure(dirname(__DIR__))
    ->withRouting(web: __DIR__ . '/../routes/web.php')
    ->withMiddleware()
    ->withExceptions()
    ->create();
