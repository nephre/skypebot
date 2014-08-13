<?php

namespace Skypebot;

use \Dbus as DbusExtension;
use \DbusObject as DbusObjectExtension;
use \DbusSignal as DbusSignalExtension;
use \DbusArray as DbusArrayExtension;

/**
 * Syntax completion helper stub file
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @filesource
 */
/**
 * Class Dbus
 *
 * @package    Skypebot
 * @subpackage Engine
 *
 * @method Dbus       __construct(int $type, int $useIntrospection = 0) $type is one of Dbus::BUS_SESSION or Dbus::BUS_SYSTEM
 * @method            addWatch()
 * @method bool       waitLoop() Checks for received signals or method calls.
 * @method            requestName(string $name) Requests a name to be assigned to this Dbus connection.
 * @method            registerObject(string $path, string $interface, string $class) Registers a callback class for the path, and with the specified interface
 * @method DbusObject createProxy(string $destination, string $path, string $interface) Creates new DbusObject object
 *
 */
class Dbus extends DbusExtension
{
    const BUS_SESSION = parent::BUS_SESSION;
    const BUS_SYSTEM = parent::BUS_SYSTEM;
}

/**
 * Class DbusObject
 *
 * @package    Skypebot
 * @subpackage Engine
 *
 * @method DbusObject __construct(Dbus $dbus, string $destination, string $path, string $interface) Creates new DbusObject object
 * @method mixed      __call($name, $arguments) Magic method
 * @method string     Invoke(string $command) Invoke Dbus command
 */
class DbusObject extends DbusObjectExtension
{ }

/**
 * Class DbusSignal
 *
 * @package    Skypebot
 * @subpackage Engine
 *
 * @method DbusSignal __construct(Dbus $dbus, string $object, string $interface, string $signal) Creates new DbusSignal object
 * @method matches()
 * @method getData()
 * @method send()
 */
class DbusSignal extends DbusSignalExtension
{ }

/**
 * Class DbusArray
 *
 * @package    Skypebot
 * @subpackage Engine
 *
 * @method DbusArray __construct(int $type, array $elements, string $signature = null) Creates new DbusArray object
 * @method getData()
 */
class DbusArray extends DbusArrayExtension
{ }
