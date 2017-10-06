<?php
namespace B1nj\ScrapingMeteoGp;

/**
 * Class Couleur
 * @package B1nj\ScrapingMeteoGp
 */
class Couleur
{
    protected $r;
    protected $v;
    protected $b;

    static public function getVigilances()
    {
        return ['verte', 'jaune', 'orange', 'rouge', 'violette', 'grise',];
    }

    static public function getNames()
    {
        return [
            'verte' => ['red' => '40', 'green' => '215', 'blue' => '97'],
            'jaune' => ['red' => '255', 'green' => '255', 'blue' => '0'],
            'orange' => ['red' => '255', 'green' => '153', 'blue' => '0'],
            'rouge' => ['red' => '224', 'green' => '0', 'blue' => '0'],
            'violette' => ['red' => '144', 'green' => '48', 'blue' => '120'],
            'grise' => ['red' => '153', 'green' => '153', 'blue' => '153'],
            'bleu' => ['red' => '163', 'green' => '211', 'blue' => '243'],
            'noir' => ['red' => '0', 'green' => '0', 'blue' => '0'],
        ];
    }

    /**
     * Couleur constructor.
     * @param $r
     * @param $v
     * @param $b
     */
    public function __construct($r, $v, $b)
    {
        $this->r = $r;
        $this->v = $v;
        $this->b = $b;
    }

    /**
     * @param $value
     * @return Couleur
     */
    public static function createFromColorIndex($value)
    {
        $r = ($value >> 16) & 0xFF;
        $v = ($value>> 8) & 0xFF;
        $b = $value & 0xFF;

        return new static($r, $v, $b);
    }

    /**
     * @param array $value
     * @return Couleur
     */
    public static function createFromArray(array $value)
    {
        return new static($value['red'], $value['green'], $value['blue']);
    }

    /**
     * @param string name
     * @return Couleur
     */
    public static function createFromName($name)
    {
        return self::createFromArray(self::getNames()[$name]);
    }

    /**
     * @param Couleur $color
     * @param int $fuzz
     * @return bool
     */
    public function isCouleurSimilar(self $color, $fuzz = 12000000)
    {
        // http://stackoverflow.com/questions/1633828/distance-between-colours-in-php/1634206#1634206
        $distance = (30 * ($this->r - $color->r)) ** 2 + (59 * ($this->v - $color->v)) ** 2 + (11 * ($this->b - $color->b)) ** 2;
        //var_dump($distance);
        return $fuzz > $distance;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        foreach ($this->getNames() as $nom => $couleur) {
            if ($this->isCouleurSimilar(self::createFromArray($couleur))) {
                return $nom;
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isVigilance()
    {
        return in_array($this->getName(), $this->getVigilances());
    }

    public function toArray()
    {
        return ['red' => $this->r, 'green' => $this->v, 'blue' => $this->b];
    }
}
