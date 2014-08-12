<?php
/**
 * @package     R-Infiniti
 * @author      Daniel Jeznach <daniel.jeznach@smtsoftware.com>
 */

require_once __DIR__ . '/vendor/autoload.php';

use Skypebot\Chat;

$chat = new Chat;
$hrv = new Harvester\Wypok;

$arr = $hrv->getSucharArray();
var_dump($arr);

die('new version below');
// new
$api = new \Wypok\Suchar;

if ($suchar = $api->getSuchar()) {
    echo $suchar;
} else {
    fprintf(STDERR, "%s\n", $api->getApi()->getError());
}

