<?php

use B1nj\ScrapingMeteoGp\Scraping;
use B1nj\ScrapingMeteoGp\Carte;
use B1nj\ScrapingMeteoGp\Exception\CarteException;


class CarteTest extends PHPUnit_Framework_TestCase
{

    protected $cartes = [
        'test7.png' => [
            'martinique' => ['vigilance' => 'jaune', 'types' => ['vent', 'pluie']],
            'guadeloupe' => ['vigilance' => 'jaune', 'types' => ['cyclone']],
            'st-martin' => ['vigilance' => 'jaune', 'types' => [/*'vent', 'pluie'*/]],
            'guyane-ne' => ['vigilance' => 'verte', 'types' => []],
            'guyane-nw' => ['vigilance' => 'verte', 'types' => []],
            'guyane-centre' => ['vigilance' => 'verte', 'types' => []],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'jaune', 'types' => [/*'vent', 'pluie'*/]],
        ],
        'test8.png' => [
            'martinique' => ['vigilance' => 'jaune', 'types' => ['cyclone']],
            'guadeloupe' => ['vigilance' => 'jaune', 'types' => ['cyclone']],
            'st-martin' => ['vigilance' => 'jaune', 'types' => ['cyclone']],
            'guyane-ne' => ['vigilance' => 'verte', 'types' => []],
            'guyane-nw' => ['vigilance' => 'verte', 'types' => []],
            'guyane-centre' => ['vigilance' => 'verte', 'types' => []],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'jaune', 'types' => ['cyclone']],
        ],
    ];

    public function testMatches()
    {
        foreach ($this->cartes as $file => $zone) {
            $vigilances = new Scraping(__DIR__.'/datas/'.$file);
            foreach ($vigilances as $scrap_zone => $vigilance) {
                if ($vigilance != $zone[$scrap_zone]) {
                    var_dump($vigilance, $zone[$scrap_zone]);
                }
                $this->assertTrue($vigilance == $zone[$scrap_zone], 'fichier : '.$file.' zone : '.$scrap_zone);
            }
        }
    }

    public function testDimensionKo()
    {
        $carte = new Carte(__DIR__.'/datas/couleurs.png');
        $this->expectException(CarteException::class);
        $carte->get();
    }


    public function testHeader()
    {
        $carte = new Carte();
        $carte->getLastModified();
    }

    /*
    public function testCarte()
    {
        $zones = new Scraping();
        var_dump($zones);
    }
    */


}