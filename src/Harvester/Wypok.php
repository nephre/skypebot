<?php

namespace Harvester;

use Symfony\Component\DomCrawler\Crawler;

/**
 * get #suchar from wypok mirko
 *
 * @package     Skypebot
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Wypok extends AbstractHarvester
{
    public function getSucharArray()
    {
        $crawler = $this->getPage('http://www.wykop.pl/tag/wpisy/suchar/');
        $data = [];

        $results = $crawler->filter('p')->each(function(Crawler $node, $i) use ($data) {
            $data[] = $node->text() . PHP_EOL;
        });

        var_dump($results);
        return $data;
    }
}
