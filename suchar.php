<?php
/**
 * @package     R-Infiniti
 * @author      Daniel Jeznach <daniel.jeznach@smtsoftware.com>
 */

require_once __DIR__ . '/vendor/autoload.php';

$api = new \Wypok\Suchar;

if ($suchar = $api->getSuchar()) {
    echo $suchar;
} else {
    fprintf(STDERR, "%s\n", $api->getApi()->getError());
}

