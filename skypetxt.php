<?php


$DBus = new Dbus( Dbus::BUS_SESSION );
 
$DBusProxy = $DBus->createProxy
    (
        "com.Skype.API", // connection name
        "/com/Skype", // object
        "com.Skype.API" // interface
    );
 
$DBusProxy->Invoke("NAME phpskype");
$DBusProxy->Invoke("PROTOCOL 6");
$rval = $DBusProxy->Invoke("CHAT CREATE " . /*saintbolo1,wzalewski_smt,*/ "loopin1982");
$data = explode(' ', $rval);
$id = $data[1];

$DBusProxy->Invoke("CHATMESSAGE " . $id. " To działało!");

