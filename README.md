SkypeBot
========
Playing around with Skype D-Bus API. Useful for skype auto-reminders, spamming group chats with random content, etc :)

Description
-----------
This "project" uses Skype-D-Bus API, which is deprecated. Instead, developers are ancoured to user https://support.skype.com/en/faq/FA214

Despite of above fact, DBUS API can be still used in version 4.X of Skype, which is latest available on Linux. Probably that is why Skype DBUS documentation is no longer officialy published. I had to dig through the web to find it, PDF document is here:
http://kirils.org/skype/stuff/pdf/2013/SkypeSDK.pdf

News
----
* It can now list existing chats and connect to any picked one.

TODO
----
* Error handling: make separate class for it
* Create chat contacts as objects (and objects collection for multiple contacts
* more...

Limitations
-----------
I do not currently plan imlementing voice calls handling. Only chat. I also haven't tested it with skype with statically compiled Qt

Bugs
----
Not known, but features amount is also small :)

Requirements
------------
* Skype for Linux (version 4.X).
* php >= 5.3
* php-dbus extension: http://pecl.php.net/package/DBus

Credits
-------
Below list is ordered chronologically (ascending - those whom work I use most recently, are lower). Kirils is mentioned second, because when I started this project, Skype DBUS API was officialy available.

* Derick Rethans for php-dbus bindings
* Kirils Solovjovs for SkypeSDK.pdf
