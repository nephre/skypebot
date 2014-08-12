<?php

namespace Wypok;

/**
 * Suchar class container 
 *
 * @package     Skypebot
 * @version     $Id$
 * @copyright   2014 SMT Software S.A.
 * @filesource
 */
/**
 * @package     Skypebot
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Suchar 
{
    const APPLICATION_KEY = '92O81mptol';
    const APPLICATION_SECRET = '8sWx79tHBT';

    /** @var Api */
    protected $api;

    /** @var string */
    protected $suchar;

    public function __construct()
    {
        $this->api = new Api(self::APPLICATION_KEY, self::APPLICATION_SECRET);
    }

    public function getSuchar()
    {
        $result = $this->api->doRequest('search/entries', array('q' => '#suchar'));

        if ($this->api->isValid()) {
            $random = array_rand($result, 1);
            $suchar = sprintf("%s\n", $result[$random]['body']);

            $suchar = trim(preg_replace('/#(.+)/', '', $suchar));

            if (! empty($suchar)) {
                return $suchar . PHP_EOL;
            } else {
                return false;
            }
        } else {
            printf("%s\n", $this->api->getError());
            return false;
        }
    }

    /**
     * Getter for $api
     *
     * @author Daniel Jeznach <djeznach@gmail.com>
     * @access public
     *
     * @return \Wypok\Api
     */
    public function getApi()
    {
        return $this->api;
    }
}
