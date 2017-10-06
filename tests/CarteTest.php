<?php

use B1nj\ScrapingMeteoGp\Scraping;
use B1nj\ScrapingMeteoGp\Carte;
use B1nj\ScrapingMeteoGp\Exception\CarteException;


class CarteTest extends PHPUnit_Framework_TestCase
{

    protected $cartes = [
        'test.png' => [
            'martinique' => ['vigilance' => 'verte', 'types' => ['vague']],
            'guadeloupe' => ['vigilance' => 'verte', 'types' => []],
            'st-martin' => ['vigilance' => 'verte', 'types' => []],
            'guyane-ne' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guyane-nw' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guyane-centre' => ['vigilance' => 'verte', 'types' => []],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'verte', 'types' => []],
        ],
        'test2.png' => [
            'martinique' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guadeloupe' => ['vigilance' => 'jaune', 'types' => ['vent','pluie','cyclone']],
            'st-martin' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guyane-ne' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guyane-nw' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guyane-centre' => ['vigilance' => 'verte', 'types' => []],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'jaune', 'types' => ['vague']],
        ],
        'test3.png' => [
            'martinique' => ['vigilance' => 'jaune', 'types' => ['vague']],
            'guadeloupe' => ['vigilance' => 'orange', 'types' => ['vent','vague','pluie']],
            'st-martin' => ['vigilance' => 'rouge', 'types' => ['cyclone']],
            'guyane-ne' => ['vigilance' => 'verte', 'types' => []],
            'guyane-nw' => ['vigilance' => 'verte', 'types' => []],
            'guyane-centre' => ['vigilance' => 'verte', 'types' => []],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'rouge', 'types' => ['cyclone']],
        ],
        'test4.png' => [
            'martinique' => ['vigilance' => 'jaune', 'types' => ['vague','pluie']],
            'guadeloupe' => ['vigilance' => 'jaune', 'types' => ['vague','pluie']],
            'st-martin' => ['vigilance' => 'violette', 'types' => ['cyclone']],
            'guyane-ne' => ['vigilance' => 'verte', 'types' => []],
            'guyane-nw' => ['vigilance' => 'verte', 'types' => []],
            'guyane-centre' => ['vigilance' => 'verte', 'types' => []],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'violette', 'types' => ['cyclone']],
        ],
        /*
         TODO : impossible de rechercher un objet sur la zone guyane-centre et sud (couleur de fond pas bleu)
         'test5.png' => [
            'martinique' => ['vigilance' => 'verte', 'types' => []],
            'guadeloupe' => ['vigilance' => 'verte', 'types' => []],
            'st-martin' => ['vigilance' => 'verte', 'types' => []],
            'guyane-ne' => ['vigilance' => 'jaune', 'types' => ['pluie']],
            'guyane-nw' => ['vigilance' => 'verte', 'types' => []],
            'guyane-centre' => ['vigilance' => 'jaune', 'types' => ['pluie']],
            'guyane-sud' => ['vigilance' => 'verte', 'types' => []],
            'st-barth' => ['vigilance' => 'verte', 'types' => []],
        ],*/
        'test6.png' => [
            'martinique' => ['vigilance' => 'jaune', 'types' => ['vent','vague','pluie']],
            'guadeloupe' => ['vigilance' => 'orange', 'types' => ['cyclone']],
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