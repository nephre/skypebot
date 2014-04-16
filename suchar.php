<?php
/**
 * {descripton}
 *
 * @package     R-Infiniti
 * @author      Daniel Jeznach <daniel.jeznach@smtsoftware.com>
 */

use Harvester\Wypok;

require_once __DIR__ . '/vendor/autoload.php';

$wypok = new Wypok;
$suchars = $wypok->getSucharArray();

var_dump($suchars);
