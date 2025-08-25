<?php

use Kirby\Cms\App as Kirby;

// Register the plugin with Kirby
Kirby::plugin('kesabr/kb-helpers', [
    // Plugin options and extensions can be defined here
]);

// Include additional PHP files
require_once __DIR__ . '/lib/convertFractionToClass.php';