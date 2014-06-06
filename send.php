<?php
/**
 * This example sends message to skype test call. On my Linux, Skype v4.X does
 * not allow to send messages to echo123 contact.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Skypebot\Chat;
use Wypok\Suchar;

$echo123 = [
    'echo123',
];

$chat = new Chat;

die();

var_dump($chat->getProxy()->getActive());
exit;
//$id = $chat->create($theReds);
$id = $chat->connect('m3H7BbVlZNj1p4HqMXoK-V-t7-6EnMqUkoL-k-4X6KEu1jueyXwI0CnGUZ4xbrE1YH93N6QAj-kGTrl7fj2Pe825OSTTQw1WwrbbySE4O5nzKLQpnCesG54mdiMYZiqgIglnkV2i-bSJfUyC09pMEmnnOloXbNkXfZ1BFXsldngUan6tuPHOkw7cVtDSdxnp0TuPIJPxeb9FJNXLRyBuzOQ', $echo123);
echo $id;

if (false === $id) {
    printf("Error:\n%s\n", $chat->getError());
    exit(1);
}

$wypokSuchar = new Suchar;
$suchar = $wypokSuchar->getSuchar();

if ($suchar) {
    $chat->sendMessage($id, $suchar);
}

