<?php
/**
 * Print chat ID of currently open chat window
 *
 * @package     Skypebot
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */

require_once __DIR__ . '/vendor/autoload.php';

use Skypebot\Chat;

$chat = new Chat;
$ids = $chat->getActiveChats();

foreach ($ids as $id) {
    $property = $chat->getChatProperty($id, Chat::CHAT_PROP_FRIENDLYNAME);
    printf("%s\n", $property);
}

