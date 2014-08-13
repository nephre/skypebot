<?php

namespace Skypebot;

use Dbus;

/**
 * Chat class container.
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @filesource
 */
/**
 * This class uses PHP-D-Bus bindings by Derick Rethans.
 * For example presentation, see link.
 * Please examine README.md as well
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @author      Daniel Jeznach <djeznach@gmail.com>
 * @link        http://pecl.php.net/package/DBus
 * @link        http://derickrethans.nl/talks/dbus-ipc10s.pdf
 *
 * @method DbusProxy Dbus->createProxy() Dbus->createProxy(string $connectionName, string $object, string $interface) Initialize DBus connection
 */
class Chat
{
    use ErrorHandlerInstallerTrait;

    /**@#
     * Some names
     */
    /** During first run, application will register to skype with this name */
    const APPLICATION_NAME = 'nephre/skypebot';

    /** A field to experiment. I would not go  */
    const PROTOCOL_VERSION = 6;

    /** DBUS connection name */
    const DBUS_CONNECTION_NAME = 'com.Skype.API';

    /** DBUS object */
    const DBUS_OBJECT = '/com/Skype';

    /** API interface name */
    const DBUS_INTERFACE = 'com.Skype.API';

    /**@#
     * Properties from documentation
     */
    const CHAT_PROP_NAME = 'NAME';
    const CHAT_PROP_TIMESTAMP = 'TIMESTAMP';
    const CHAT_PROP_TOPIC = 'TOPIC';
    const CHAT_PROP_FRIENDLYNAME = 'FRIENDLYNAME';

    /** @var Dbus */
    protected $dbus;

    /** @var DbusProxy */
    protected $dbusProxy;

    /** @var string */
    protected $error;

    /** @var bool */
    protected $initialized = false;

    /**
     * @param  int $type one of Dbus::BUS_SESSION or Dbus::BUS_SYSTEM
     *
     * @throws Exception
     */
    public function __construct($type = Dbus::BUS_SESSION)
    {
        $this->setErrorHandlers();

        if (!extension_loaded('dbus')) {
            throw new Exception('DBUS extension not found. This application requires php-dbus extension to be loaded.', Error::ERR_MISSING_DBUS_EXTENSION);
        }

        $this->dbus      = new Dbus($type);
        $this->dbusProxy = $this
            ->dbus
            ->createProxy(
                self::DBUS_CONNECTION_NAME,
                self::DBUS_OBJECT,
                self::DBUS_INTERFACE
            );
    }

    /**
     * Get dbus proxy
     *
     * @author Daniel Jeznach <djeznach@gmail.com>
     * @access public
     *
     * @return DbusProxy
     */
    public function getProxy()
    {
        return $this->dbusProxy;
    }

    /**
     * Search active chats, returns IDs of chats
     *
     * @author Daniel Jeznach <djeznach@gmail.com>
     * @access public
     *
     * @return array
     */
    public function getActiveChats()
    {
        $ids = null;

        try {
            $this->initConnection();
            $rval = $this->dbusProxy->Invoke("SEARCH ACTIVECHATS");
            $ids  = explode(',', substr($rval, 6));
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }

        return $ids;
    }

    /**
     * Introduce itself to skype
     */
    public function initConnection()
    {
        if ($this->initialized) {
            return;
        }

        $this->dbusProxy->Invoke("NAME " . self::APPLICATION_NAME);
        $this->dbusProxy->Invoke("PROTOCOL " . self::PROTOCOL_VERSION);

        $this->initialized = true;
    }

    /**
     * Get chat property
     *
     * @author Daniel Jeznach <djeznach@gmail.com>
     * @access public
     *
     * @param  string $id
     * @param  string $property
     *
     * @return string ?
     */
    public function getChatProperty($id, $property)
    {
        try {
            $this->initConnection();

            $cmd  = sprintf("GET CHAT %s %s", $id, $property);
            $rval = $this->dbusProxy->Invoke($cmd);
            $ids  = $rval;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }

        return $ids;
    }

    /**
     * Create chat and return chat ID
     *
     * @param  array $contacts skype names
     *
     * @return string|bool
     */
    public function create(array $contacts)
    {
        try {
            $this->initConnection();
            $rval = $this->dbusProxy->Invoke(
                "CHAT CREATE " . implode(',', $contacts)
            );
            $data = explode(' ', $rval);
            $id   = $data[1];
        } catch (\Exception $e) {
            $id           = false;
            $this->error = $e->getMessage();
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
        $response = $this->dbusProxy->Invoke(
            "CHATMESSAGE " . $id . " " . $message
        );

        if (strpos($response, 'ERROR') === 0) {
            $this->error = $response;
            trigger_error($response, E_USER_ERROR);
        }
    }

    /**
     * Returns last error message
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}
