<?php
/**
 * This one sends wypok suchar to chat by given id.
 * Use activechats.php to get currently open chat window
 */

require_once __DIR__ . '/vendor/autoload.php';

use Skypebot\Chat;
use Wypok\Suchar;

if (empty($argv[1])) {
    fprintf(STDERR, "Usage:\nphp %s <chat_id>\n", $argv[0]);
    exit(1);
}

$id = $argv[1];
$chat = new Chat;

$wypokSuchar = new Suchar;
$suchar = $wypokSuchar->getSuchar();

if ($suchar) {
    echo $suchar;
    $chat->sendMessage($id, $suchar);
}
