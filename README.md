SkypeBot
========
Playing around with Skype D-Bus API. Useful for skype auto-reminders, spamming group chats with random content, etc :)

Description
-----------
This "project" uses Skype-D-Bus API, which is deprecated. Yet it can be still used
in version 4.X of Skype, which is latest available on Linux. Besides, Skype developers say DBUS support will be dropped in next version of Skype for Linux.

Note: I do not currently plan imlementing voice calls handling. Only chat.

It can now list existing chats and connect to any picked one.

TODO
----
* Error handling: make separate class for it
* Create chat contacts as objects (and objects collection for multiple contacts
* more...

Requirements
------------
* Skype for Linux (version 4.X).
* php-dbus extension: http://pecl.php.net/package/DBus

Credits
-------
Derick Rethans for php-dbus bindings. (above link)
