<?php
namespace B1nj\ScrapingMeteoGp;

class Pixel
{
    public $x;
    public $y;
    protected $gd_resource;

    /**
     * Pixel constructor.
     * @param $x
     * @param $y
     * @param $color_index
     */
    public function __construct($x, $y, $gd_resource)
    {
        $this->x = $x;
        $this->y = $y;
        $this->gd_resource = $gd_resource;
    }

    public function couleur()
    {
        $color_index = imagecolorat($this->gd_resource, $this->x, $this->y);

        return Couleur::createFromColorIndex($color_index);
    }
}
