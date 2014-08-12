<?php

namespace Skypebot;

/**
 * Exception class container
 *
 * @package     Skypebot
 * @filesource
 */
/**
 * Skypebot exception
 *
 * @package     Skypebot
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Exception extends \Exception
{
    /**
     * Do not use
     *
     * @deprecated
     * @return string
     */
    public function __toString()
    {
        $trace = $this->getTrace();
        array_push(
            $trace,
            [
                'file' => $this->getFile(),
                'line' => $this->getLine(),
                'function' => __METHOD__,
                'class' => __CLASS__,
                'args' => func_get_args(),
                'type' => '::',
            ]
        );

        $traceString = '';
        foreach ($trace as $stepNo => $step) {
            $traceString .= sprintf(
                '#%d %s(%d): %s%s%s (%s)' . "\n",
                $stepNo,
                $step['file'],
                $step['line'],
                $step['class'],
                $step['type'],
                $step['function'],
                implode(', ', $step['args'])
            );
        }

        return $traceString;
    }
}
