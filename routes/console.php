<?php

use Illuminate\\Support\\Facades\\Artisan;

Artisan::command('indiauncaged:info', function () {
    $this->info('India Uncaged foundation is installed.');
})->purpose('Display India Uncaged application information');
