<?php
namespace B1nj\ScrapingMeteoGp;

class Mire
{
    public $x;
    public $y;

    /**
     * @var Couleur
     */
    public $couleur;

    /**
     * Mire constructor.
     * @param $x
     * @param $y
     * @param Couleur $couleur
     */
    public function __construct($x, $y, Couleur $couleur)
    {
        $this->x = $x;
        $this->y = $y;
        $this->couleur = $couleur;
    }

    /**
     * @param array $value
     * @return Mire
     */
    public static function createFromArray(array $value)
    {
        $position = $value['position'];
        $couleur = Couleur::createFromArray($value['couleur']);
        return new static($position[0], $position[1], $couleur);
    }
}
