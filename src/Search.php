<?php
namespace B1nj\ScrapingMeteoGp;

class Search
{
    /**
     * @var Carte
     */
    protected $carte;

    /**
     * @var Objet
     */
    protected $objet;

    protected $zone_top_left;
    protected $zone_bottom_right;



    /**
     * Search constructor.
     * @param Carte $carte
     * @param Objet $objet
     * @param array $points
     */
    public function __construct(Carte $carte, $objet = null, $points = null)
    {
        $this->carte = $carte;

        if (is_null($points)) {
            $this->zone_top_left = [0, 0];
            $this->zone_bottom_right = [$carte->width(), $carte->height()];
        } else {
            $this->setZone($points);
        }

        if (!is_null($objet)) {
            $this->setObjet($objet);
        }

    }

    /**
     * @param array $zone
     */
    public function setZone($points)
    {
        $this->zone_top_left = $points[0];
        $this->zone_bottom_right = $points[1];
    }

    /**
     * @param Objet $objet
     */
    public function setObjet(Objet $objet)
    {
        $this->objet = $objet;
    }


    public function match()
    {
        for ($y = $this->zone_top_left[1]; $y <= $this->zone_bottom_right[1]; $y++) {
            for ($x = $this->zone_top_left[0]; $x <= $this->zone_bottom_right[0]; $x++) {
                // dépassement de carte
                if ($x + $this->objet->mire_principal->x >= $this->carte->width() or $y + $this->objet->mire_principal->y >= $this->carte->height()) {
                    continue;
                }
                $pixel = $this->carte->getPixell($x + $this->objet->mire_principal->x, $y + $this->objet->mire_principal->y);
                if ($pixel->couleur()->isCouleurSimilar($this->objet->mire_principal->couleur)) {
                    $match = true;
                    foreach ($this->objet as $mire) {
                        // dépassement de carte
                        if ($x + $mire->x >= $this->carte->width() or $y + $mire->y >= $this->carte->height()) {
                            continue;
                        }
                        $pixel_mire = $this->carte->getPixell($x + $mire->x, $y + $mire->y);
                        if (!$pixel_mire->couleur()->isCouleurSimilar($mire->couleur)) {
                            $match = false;
                            break;
                        }
                    }
                    if ($match) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
