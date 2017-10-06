<?php
namespace B1nj\ScrapingMeteoGp;

use Iterator;
use Exception;

class Objet implements Iterator
{
    protected $mires = [];

    public $mire_principal;

    public static function getObjetsArray()
    {
        return [
            // Vent
            'vent' => [
                ['position' => [18, 1], 'couleur' => ['red' => '30', 'green' => '40', 'blue' => '50']],
                ['position' => [18, 18], 'couleur' => ['red' => '30', 'green' => '40', 'blue' => '50']],
                ['position' => [14, 12], 'couleur' => ['red' => '163', 'green' => '211', 'blue' => '243']],
                ['position' => [12, 6], 'couleur' => ['red' => '163', 'green' => '211', 'blue' => '243']],
                ['position' => [7, 7], 'couleur' => ['red' => '160', 'green' => '207', 'blue' => '238']],
                ['position' => [7, 3], 'couleur' => ['red' => '160', 'green' => '207', 'blue' => '238']],
                ['position' => [14, 3], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [9, 6], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [4, 7], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
            ],
            // Vague
            'vague' => [
                ['position' => [12, 2], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [17, 9], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [10, 7], 'couleur' => ['red' => '163', 'green' => '211', 'blue' => '243']],
                ['position' => [17, 4], 'couleur' => ['red' => '163', 'green' => '211', 'blue' => '243']],
                ['position' => [2, 8], 'couleur' => ['red' => '163', 'green' => '211', 'blue' => '243']],
                ['position' => [2, 5], 'couleur' => ['red' => '3', 'green' => '3', 'blue' => '3']],
                ['position' => [5, 9], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
            ],
            // Pluie
            'pluie' => [
                ['position' => [7, 2], 'couleur' => ['red' => '13', 'green' => '13', 'blue' => '13']],
                ['position' => [3, 5], 'couleur' => ['red' => '3', 'green' => '3', 'blue' => '3']],
                ['position' => [3, 12], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [12, 11], 'couleur' => ['red' => '98', 'green' => '110', 'blue' => '118']],
                ['position' => [16, 6], 'couleur' => ['red' => '16', 'green' => '16', 'blue' => '16']],
                ['position' => [9, 7], 'couleur' => ['red' => '163', 'green' => '211', 'blue' => '243']],
            ],
            // cyclone
            'cyclone' => [
                ['position' => [5, 11], 'couleur' => ['red' => '255', 'green' => '255', 'blue' => '255']],
                ['position' => [4, 5], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [8, 0], 'couleur' => ['red' => '71', 'green' => '71', 'blue' => '71']],
                ['position' => [1, 21], 'couleur' => ['red' => '90', 'green' => '90', 'blue' => '90']],
                ['position' => [5, 17], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
            ],
        ];
    }

    public static function getObjets()
    {
        $objets = [];
        foreach (self::getObjetsArray() as $objet_id => $objet_array) {
            $objets[$objet_id] = self::createFromArray($objet_array);
        }
        return $objets;
    }

    /**
     * Objet constructor.
     * @param array $mires
     */
    public function __construct(array $mires = null)
    {
        if ($mires !== null) {
            foreach ($mires as $mire) {
                $this->addMire($mire);
            }
        }
    }

    /**
     * @param array $mires_array
     * @return Objet
     */
    public static function createFromArray(array $mires_array)
    {
        $mires= [];

        foreach ($mires_array as $mire) {
            $mires[] = Mire::createFromArray($mire);
        }
        return new static($mires);
    }

    public static function createById($id)
    {
        $objets = self::getObjetsArray();

        if (!isset($objets[$id])) {
            throw new Exception("L'id $id n'existe pas");
        }

        return self::createFromArray($objets[$id]);
    }

    public function addMire(Mire $value)
    {
        if ($this->mire_principal === null) {
            $this->mire_principal = $value;
        } else {
            $this->mires[] = $value;
        }
    }


    public function rewind()
    {
        reset($this->mires);
    }

    public function current()
    {
        return current($this->mires);
    }

    public function key()
    {
        return key($this->mires);
    }

    public function next()
    {
        return next($this->mires);
    }

    public function valid()
    {
        return $this->current() !== false;
    }
}
