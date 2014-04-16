<?php

namespace Harvester;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * AbstractHarvester class container 
 *
 * @package     R-Infiniti
 * @version     $Id$
 * @copyright   2014 SMT Software S.A.
 * @filesource
 */
/**
 * @package     R-Infiniti
 * @author      Daniel Jeznach <daniel.jeznach@smtsoftware.com>
 */
abstract class AbstractHarvester
{
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
