<?php

namespace Wypok;

/**
 * Suchar class container
 *
 * @package     Skypebot
 * @subpackage  Wypok
 * @filesource
 */
/**
 * @package     Skypebot
 * @subpackage  Wypok
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Suchar
{
    /**@#
     * Constants
     */
    const APPLICATION_KEY       = '92O81mptol';
    const APPLICATION_SECRET    = '8sWx79tHBT';

    /** @var Api */
    protected $api;

    /** @var string */
    protected $suchar;

    public function __construct()
    {
        $this->api = new Api(self::APPLICATION_KEY, self::APPLICATION_SECRET);
    }

    /**
     * Returns joke, or false in case of API error
     *
     * @return bool|string
     */
    public function getSuchar()
    {
        $result = $this->api->doRequest(
            'search/entries',
            array('q' => '#suchar')
        );

        if ($this->api->isValid()) {
            $random = array_rand($result, 1);
            $suchar = sprintf("%s\n", $result[$random]['body']);

            $suchar = trim(preg_replace('/#(.+)/', '', $suchar));

            if (!empty($suchar)) {
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
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }
}
