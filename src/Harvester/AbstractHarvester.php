<?php

namespace Harvester;

use Skypebot\ErrorHandlerInstaller;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * AbstractHarvester class container 
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
abstract class AbstractHarvester
{
    use ErrorHandlerInstaller;

    public function __construct()
    {
        $this->setErrorHandlers();

        $dependencies = [
            'Goutte\Client',
            'Symfony\Component\DomCrawler\Crawler',
        ];

        foreach ($dependencies as $class) {
            if (!class_exists($class, false)) {
                trigger_error("Unable to load class: $class", E_USER_ERROR);
            }
        }
    }

    /**
     * @param  $url
     * @return Crawler
     */
    public function getPage($url)
    {
        $client = new Client;
        $crawler = $client->request('GET', $url);

        return $crawler;
    }
}
