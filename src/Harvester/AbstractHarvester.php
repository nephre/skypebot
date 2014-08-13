<?php

namespace Harvester;

use Goutte\Client;
use Skypebot\Error;
use Skypebot\ErrorHandlerInstallerTrait;
use Skypebot\Exception;
use Symfony\Component\DomCrawler\Crawler;

/**
 * AbstractHarvester class container
 *
 * @package     Skypebot
 * @subpackage  Harvester
 * @filesource
 */
/**
 * @package     Skypebot
 * @subpackage  Harvester
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
abstract class AbstractHarvester
{
    use ErrorHandlerInstallerTrait;

    public function __construct()
    {
        $this->setErrorHandlers();

        $dependencies = [
            'Goutte\Client',
            'Symfony\Component\DomCrawler\Crawler',
        ];

        foreach ($dependencies as $class) {
            if (!class_exists($class, false)) {
                throw new Exception("Unable to load dependency class: $class", Error::ERR_MISSING_CLASS);
            }
        }
    }

    /**
     * @param  $url
     *
     * @return Crawler
     */
    public function getPage($url)
    {
        $client  = new Client;
        $crawler = $client->request('GET', $url);

        return $crawler;
    }
}
