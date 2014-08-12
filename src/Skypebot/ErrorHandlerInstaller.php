<?php

namespace Skypebot;

/**
 * ErrorHandlerInstaller trait container
 *
 * @package     Skypebot
 * @filesource
 */
/**
 * Installs error and exception handlers
 *
 * @package     Skypebot
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
trait ErrorHandlerInstaller {
    protected $errorHandler;

    public function setErrorHandlers()
    {
        $this->errorHandler = new Error;

        set_error_handler(array($this->errorHandler, 'error'));
        set_exception_handler(array($this->errorHandler, 'exception'));
    }
}
