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
                ['position' => [17, 4], 'couleur' => ['red' => '19', 'green' => '19', 'blue' => '0']],
                ['position' => [15, 6], 'couleur' => ['red' => '3', 'green' => '3', 'blue' => '0']],
                ['position' => [10, 7], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [13, 7], 'couleur' => ['red' => '255', 'green' => '255', 'blue' => '255']],
                ['position' => [15, 8], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [7, 9], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [9, 9], 'couleur' => ['red' => '254', 'green' => '254', 'blue' => '254']],
                ['position' => [4, 10], 'couleur' => ['red' => '148', 'green' => '148', 'blue' => '129']],
                ['position' => [17, 11], 'couleur' => ['red' => '25', 'green' => '25', 'blue' => '0']],
                ['position' => [17, 18], 'couleur' => ['red' => '33', 'green' => '33', 'blue' => '0']],
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
                ['position' => [8, 4], 'couleur' => ['red' => '22', 'green' => '22', 'blue' => '12']],
                ['position' => [7, 6], 'couleur' => ['red' => '193', 'green' => '193', 'blue' => '193']],
                ['position' => [13, 7], 'couleur' => ['red' => '111', 'green' => '111', 'blue' => '111']],
                ['position' => [5, 8], 'couleur' => ['red' => '10', 'green' => '10', 'blue' => '10']],
                ['position' => [12, 8], 'couleur' => ['red' => '159', 'green' => '159', 'blue' => '159']],
                ['position' => [15, 8], 'couleur' => ['red' => '36', 'green' => '36', 'blue' => '36']],
                ['position' => [8, 10], 'couleur' => ['red' => '13', 'green' => '13', 'blue' => '12']],
                ['position' => [6, 11], 'couleur' => ['red' => '189', 'green' => '189', 'blue' => '189']],
                ['position' => [4, 13], 'couleur' => ['red' => '8', 'green' => '8', 'blue' => '8']],
            ],
            // cyclone
            'cyclone' => [
                ['position' => [7, 5], 'couleur' => ['red' => '20', 'green' => '20', 'blue' => '0']],
                ['position' => [6, 7], 'couleur' => ['red' => '0', 'green' => '0', 'blue' => '0']],
                ['position' => [6, 12], 'couleur' => ['red' => '255', 'green' => '255', 'blue' => '255']],
                ['position' => [7, 16], 'couleur' => ['red' => '16', 'green' => '16', 'blue' => '16']],
                ['position' => [6, 18], 'couleur' => ['red' => '2', 'green' => '2', 'blue' => '0']],
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
