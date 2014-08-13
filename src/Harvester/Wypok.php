<?php

namespace Harvester;

use Symfony\Component\DomCrawler\Crawler;

/**
 * AbstractHarvester class container
 *
 * @package     Skypebot
 * @subpackage  Harvester
 * @filesource
 */
/**
 * get #suchar from wypok mirko
 *
 * @package     Skypebot
 * @subpackage  Harvester
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Wypok extends AbstractHarvester
{
    /**
     * @return array
     */
    public function getSucharArray()
    {
        $crawler = $this->getPage('http://www.wykop.pl/tag/wpisy/suchar/');
        $data    = [];

        $results = $crawler->filter('p')->each(
            function (Crawler $node, $i) use ($data) {
                $data[] = $node->text() . PHP_EOL;
            }
        );

        var_dump($results);

        return $data;
    }
}
