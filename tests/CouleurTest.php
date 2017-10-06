<?php

use B1nj\ScrapingMeteoGp\Couleur;
use B1nj\ScrapingMeteoGp\Carte;

class CouleurTest extends PHPUnit_Framework_TestCase
{

    protected $file = __DIR__.'/datas/couleurs.png';

    protected $pixels = [[0,0,'verte'], [10,0,'jaune'], [20,0,'orange'], [30,0,'rouge'], [40,0,'violette'], [50,0,'grise'], [6,0,'bleu'], [60,0,'noir']];

    public function testMatches()
    {
        $this->carte = $carte = new Carte($this->file);
        $carte->get(false);

        foreach ($this->pixels as $pixel) {
            $couleur = $carte->getPixell($pixel[0], $pixel[1])->couleur()->getName();
            $this->assertEquals($couleur, $pixel[2]);
        }
    }

    public function testNoMatches()
    {
        $this->carte = $carte = new Carte($this->file);
        $carte->get(false);

        foreach ($this->pixels as $pixel) {
            $couleur = $carte->getPixell($pixel[0], $pixel[1])->couleur();
            $pixel_vigilance_couleur = $couleur->getName();
            foreach ($couleur->getVigilances() as $vigilance) {
                $color = Couleur::createFromArray($couleur->getNames()[$vigilance]);
                if ($pixel_vigilance_couleur != $color->getName()) {
                    $this->assertFalse($couleur->isCouleurSimilar($color));
                }
            }
        }
    }

}