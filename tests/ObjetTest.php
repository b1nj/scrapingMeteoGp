<?php

use B1nj\ScrapingMeteoGp\Search;
use B1nj\ScrapingMeteoGp\Objet;
use B1nj\ScrapingMeteoGp\Carte;

class ObjetTest extends PHPUnit_Framework_TestCase
{

    protected $file = __DIR__.'/datas/objets.png';

    protected $zones = [
        [[0,0], [29,19], 'vague'],
        /*[[30,0], [59,19], 'vague'],
        [[60,0], [89,19], 'vague'],
        [[90,0], [119,19], 'vague'],*/
        [[0,20], [29,49], 'vent'],
        [[0,50], [29,74], 'pluie'],
        [[30,75], [59,104], 'cyclone'],
        [[60,75], [89,104], 'cyclone'],
    ];

    public function testMatches()
    {
        $this->carte = $carte = new Carte($this->file);
        $carte->get(false);

        foreach ($this->zones as $key => $zone) {
            $search = new Search($carte, Objet::createById($zone[2]), $zone);
            $this->assertTrue($search->match(), 'id : '.$zone[2].' objet : '.($key + 1));
        }
    }

    public function testNoMatches()
    {
        $this->carte = $carte = new Carte($this->file);
        $carte->get(false);

        foreach ($this->zones as $key => $zone) {
            $objets_trouves = [];
            foreach (Objet::getObjets() as $objet_id => $objet) {
                $search = new Search($carte, $objet, $zone);
                if ($search->match()) {
                    $objets_trouves[] = $objet_id;
                }
            }
            $this->assertLessThanOrEqual(1, count($objets_trouves), 'ids : '.implode(',', $objets_trouves).' objet : '.($key + 1));
        }
    }

}