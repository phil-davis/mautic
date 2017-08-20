<?php
require __DIR__ . '/../../../../vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("Page\\", __DIR__. "/../lib", true);
$classLoader->addPsr4("TestHelpers\\", __DIR__. "/../../../TestHelpers/", true);

$classLoader->register();

// Sleep for 10 milliseconds
const STANDARD_SLEEP_TIME_MILLISEC = 10;
const STANDARD_SLEEP_TIME_MICROSEC = STANDARD_SLEEP_TIME_MILLISEC * 1000;

// Default timeout for use in code that needs to wait for the UI
const STANDARD_UI_WAIT_TIMEOUT_MILLISEC = 10000;
