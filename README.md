SkypeBot
========
Playing around with Skype D-Bus API bindings for PHP.
Useful for Skype auto-reminders, spamming group chats with jokes or random content, etc :)

Description
-----------
This "project" uses Skype D-Bus API, which is, unfortunately, already deprecated. Instead, developers are encouraged to use [Desktop API](https://support.skype.com/en/faq/FA214).
Despite of above fact, DBUS API can be still used in version 4.X of Skype, which is latest available on Linux. Probably that is why Skype DBUS documentation is no longer officially published. I had to dig through the web to find it, PDF document is [here](http://kirils.org/skype/stuff/pdf/2013/SkypeSDK.pdf). See [credits](#credits) section as well.

Basic usage is very simple, just open your skype client, and open chat window with someone. Then, run from console:
```php activechats.php```

You should return chat ID of currently active chat window, something like:
```CHAT #myskypeid/$friends.skype.id;cc5250703ad99efb FRIENDLYNAME My Friend Name```

To send message, just type:
```php send.php '#myskypeid/$friends.skype.id;cc5250703ad99efb' Your message here```

Check your skype window, you've just sent message to your contact.

News
----
* It can now list existing chats and connect to any picked one.
* Error handling
* Generated docs: use phpdoc/phpdocumentor, with following command:
```phpdoc -t docs -f "src/Skypebot/*.php" -e dbus --title SkypeBot --sourcecode -p --parseprivate --validate```

TODO
----
* Create chat contacts as objects (and objects collection for multiple contacts
* Prepare PHAR archive with parameters
* more...

Limitations
-----------
I do not currently plan implementing voice calls handling. Only chats support. I also haven't tested it with Skype against with statically compiled Qt (like, for instance, in PC-BSD packages)

Bugs
----
Not known, but features amount is also small :)

Requirements
------------
* Linux OS (*-BSD probably also will be supported, as long as DBUS and Skype works there. No guarantee yet
* Skype for Linux (version 4.X).
* php >= 5.4
* [php-dbus extension](http://pecl.php.net/package/DBus)
* [composer](https://getcomposer.org/download/) - used for autoloading, mainly. Some subscripts also utilise fabpot/goutte, but it's not mandatory to communicate with Skype

Credits
-------
Below list is ordered chronologically (ascending - those whom work I use most recently, are being added to the list). Kirils is mentioned second, because when I started this project, Skype DBUS API documentation was officially available.

* Derick Rethans for php-dbus bindings
* Kirils Solovjovs for SkypeSDK.pdf
