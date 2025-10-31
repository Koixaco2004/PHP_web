<?php
require __DIR__ . '/../bootstrap/app.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo "view.compiled = ";
var_export($app['config']['view.compiled']);
echo PHP_EOL;
