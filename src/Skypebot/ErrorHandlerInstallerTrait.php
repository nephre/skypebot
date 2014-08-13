<?php

namespace Skypebot;

/**
 * ErrorHandlerInstallerTrait trait container
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @filesource
 */
/**
 * Installs error and exception handlers
 *
 * @package     Skypebot
 * @subpackage  Engine
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
trait ErrorHandlerInstallerTrait {
    /** @var Error */
    protected $errorHandler;

    public function setErrorHandlers()
    {
        $this->errorHandler = new Error;

        set_error_handler(array($this->errorHandler, 'error'));
        set_exception_handler(array($this->errorHandler, 'exception'));
    }
}
