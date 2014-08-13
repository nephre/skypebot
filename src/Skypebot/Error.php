<?php

namespace Skypebot;

/**
 * Error class container
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @filesource
 */
/**
 * Error handler
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Error
{
    /**@#
     * Error codes
     */
    const ERR_NO_CHAT_ID = 1;
    const ERR_CHAT_ID_INVALID = 2;
    const ERR_NO_CHAT_MESSAGE = 3;
    const ERR_DBUS_CALL_ERROR = 4;
    const ERR_MISSING_DBUS_EXTENSION = 5;
    const ERR_MISSING_CLASS = 256;

    /** @var array Error code => message */
    protected $errors = [
        self::ERR_NO_CHAT_ID      => 'No chat ID provided',
        self::ERR_CHAT_ID_INVALID => 'Invalid chat ID (invalid format or chat not found)',
        self::ERR_NO_CHAT_MESSAGE => 'Chat message is empty',
        self::ERR_DBUS_CALL_ERROR => 'Skype API returned error: %s',
        self::ERR_MISSING_CLASS   => 'Autoloading error: %s. Make sure all dependencies are installed.',
    ];

    /** @var array Error code => [variables to eval] */
    protected $errorParams = [
        self::ERR_MISSING_CLASS   => ['errstr'],
        self::ERR_DBUS_CALL_ERROR => ['errcontext[\'response\']'],
    ];

    /**
     * @param  int $error One of ERR_* const. Used also as exit code
     * @return int        Exit code
     */
    public function printUsage($error)
    {
        fprintf(
            STDERR,
            "Usage:\nphp %s <chat_id> <message>\n",
            $_SERVER['SCRIPT_NAME']
        );
        return $error;
    }

    /**
     * @param int|string $errno If string given to trigger_error, it will be displayed
     * @param string     $errstr
     * @param string     $errfile
     * @param int        $errline
     * @param array      $errcontext
     */
    public function error($errno, $errstr, $errfile, $errline, $errcontext)
    {
        if (is_integer($errstr) && array_key_exists($errstr, $this->errors)) {
            $message = $this->errors[$errstr];

            if (array_key_exists($errstr, $this->errorParams)) {
                $errParams = [];

                foreach ($this->errorParams[$errstr] as /*$errorCode => */
                         $errorData) {
                    $errParams[] = print_r(${$errorData}, true);
                }

                $message = call_user_func_array('sprintf', $errParams);
            }
        } else {
            $message = $errstr;
        }

        fprintf(
            STDERR,
            "An error has occured in %s:%d\n%s\nExiting with code %d\n",
            $errfile,
            $errline,
            $message,
            $errno
        );

        exit($errno);
    }

    /**
     * @param  \Exception $exception
     */
    public function exception($exception)
    {
        fprintf(
            STDERR,
            "An exception has been thrown in %s:%d\n%s\nStacktrace:\n%s\nExiting with code %d\n",
            $exception->getFile(),
            $exception->getLine(),
            $exception->getMessage(),
            $exception->getTraceAsString(),
            $exception->getCode()
        );

        exit($exception->getCode());
    }
}
