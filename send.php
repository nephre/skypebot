<?php
/**
 * This one sends console message to chat by given id.
 *
 * Use activechats.php to get currently open chat window. Then:
 * php send.php '<chat id>' your message
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */

require_once __DIR__ . '/vendor/autoload.php';

use Skypebot\Chat;
use Skypebot\Error;

$chat = new Chat;

if (empty($argv[1])) {
    trigger_error(Error::ERR_NO_CHAT_ID, E_USER_ERROR);
}

$messageArray = array_slice($argv, 2);

if (empty($messageArray) || ! is_array($messageArray)) {
    trigger_error(Error::ERR_NO_CHAT_MESSAGE, E_USER_ERROR);
}

$id = $argv[1];

$message = implode(' ', $messageArray);
$chat->sendMessage($id, $message);
