<?php

namespace Skypebot;
use \Dbus;

/**
 * Chat class container.
 *
 * @package     R-Infiniti
 * @version     $Id$
 * @copyright   2013 SMT Software S.A.
 * @filesource
 */
/**
 * This class uses PHP-D-Bus bindings by Derick Rethans.
 * For example presentation, see link
 *
 * @package     R-Infiniti
 * @author      Daniel Jeznach <daniel.jeznach@smtsoftware.com>
 * @link        http://pecl.php.net/package/DBus
 * @link        http://derickrethans.nl/talks/dbus-ipc10s.pdf
 */
class Chat 
{
    /**@#
     * Some names
     */
    const APPLICATION_NAME      = 'phpskype';
    const PROTOCOL_VERSION      = 6;

    const DBUS_CONNECTION_NAME  = 'com.Skype.API';
    const DBUS_OBJECT           = '/com/Skype';
    const DBUS_INTERFACE        = 'com.Skype.API';

    const CHAT_PROP_NAME        = 'NAME';
    const CHAT_PROP_TIMESTAMP   = 'TIMESTAMP';
    const CHAT_PROP_TOPIC       = 'TOPIC';
    const CHAT_PROP_FRIENDLYNAME= 'FRIENDLYNAME';

    /** @var Dbus */
    protected $_dbus;

    /** @var DbusProxy */
    protected $_dbusProxy;

    /** @var string */
    protected $_error;

    /** @var bool */
    protected $_initialized = false;

    /**
     * @param  int $type one of Dbus::BUS_SESSION or Dbus::BUS_SYSTEM
     * @throws \RuntimeException
     */
    public function __construct($type = Dbus::BUS_SESSION)
    {
        if (! extension_loaded('dbus')) {
            throw new \RuntimeException('DBUS extension not found. This class requires php-dbus extension to be loaded.');
        }

        $this->_dbus = new Dbus($type);
        $this->_dbusProxy = $this
            ->_dbus
            ->createProxy(self::DBUS_CONNECTION_NAME, self::DBUS_OBJECT, self::DBUS_INTERFACE);
    }

    /**
     * Get dbus proxy
     *
     * @author Daniel Jeznach <daniel.jeznach@smtsoftware.com>
     * @access public
     *
     * @return \Skypebot\DbusProxy
     */
    public function getProxy()
    {
        return $this->_dbusProxy;
    }

    /**
     * Search active chats, returns IDs of chats
     *
     * @author Daniel Jeznach <daniel.jeznach@smtsoftware.com>
     * @access public
     *
     * @return array
     */
    public function getActiveChats()
    {
        $ids = null;

        try {
            $this->initConnection();
            $rval = $this->_dbusProxy->Invoke("SEARCH ACTIVECHATS");
            $ids = explode(',', substr($rval, 6));
        } catch (\Exception $e) {
            $this->_error = $e->getMessage();
        }

        return $ids;
    }

    /**
     * Get chat property
     *
     * @author Daniel Jeznach <daniel.jeznach@smtsoftware.com>
     * @access public
     *
     * @param  string $id
     * @param  string $property
     * @return string ?
     */
    public function getChatProperty($id, $property)
    {
        try {
            $this->initConnection();

            $cmd = sprintf("GET CHAT %s %s", $id, $property);
            $rval = $this->_dbusProxy->Invoke($cmd);
            $ids = $rval;
        } catch (\Exception $e) {
            $this->_error = $e->getMessage();
        }

        return $ids;
    }

    /**
     * Introduce itself to skype
     */
    public function initConnection()
    {
        if ($this->_initialized) {
            return;
        }

        $this->_dbusProxy->Invoke("NAME " .  self::APPLICATION_NAME);
        $this->_dbusProxy->Invoke("PROTOCOL " . self::PROTOCOL_VERSION);

        $this->_initialized = true;
    }

    /**
     * Create chat and return chat ID
     *
     * @param  array $contacts skype names
     * @return string|bool
     */
    public function create(array $contacts)
    {
        try {
            $this->initConnection();
            $rval = $this->_dbusProxy->Invoke("CHAT CREATE " . implode(',', $contacts));
            $data = explode(' ', $rval);
            $id = $data[1];
        } catch (\Exception $e) {
            $id = false;
            $this->_error = $e->getMessage();
        }

        return $id;
    }

    /**
     * Send chat message to chat ID (received from create())
     *
     * @param  string $id      Chat ID
     * @param  string $message Chat message
     */
    public function sendMessage($id, $message)
    {
        $this->initConnection();
        $this->_dbusProxy->Invoke("CHATMESSAGE " . $id. " " . $message);
    }

    /**
     * Returns last error message
     *
     * @return string
     */
    public function getError()
    {
        return $this->_error;
    }
}
