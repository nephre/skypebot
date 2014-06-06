<?php
/**
 * {descripton}
 *
 * @package     skypebot
 * @author      Daniel Jeznach <daniel.jeznach@smtsoftware.com>
 */

require_once __DIR__ . '/vendor/autoload.php';

use Skypebot\Chat;

$chat = new Chat;
$ids = $chat->getActiveChats();

foreach ($ids as $id) {
    $property = $chat->getChatProperty($id, Chat::CHAT_PROP_FRIENDLYNAME);
    printf("%s\n", $property);
}

