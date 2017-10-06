<?php
namespace B1nj\ScrapingMeteoGp;

use Carbon\Carbon;
use ArrayIterator;
use IteratorAggregate;

class Scraping implements IteratorAggregate
{
    protected $carte;
    protected $vigilances = [];


    protected $nom_fichier_date;

    /**
     * Scraping constructor.
     * @param $filename
     * @param $nom_fichier_date fichier contenant
     */
    public function __construct($filename = null, $nom_fichier_date = null)
    {

        $this->nom_fichier_date = $nom_fichier_date;

        $this->carte = $carte = new Carte($filename);

        if (!is_null($nom_fichier_date) and !$carte->hasNewUpdate($this->getlastModifiedKnown())) {
            // Pas de changement
            return;
        }

        $carte->get();

        if (!is_null($nom_fichier_date)) {
            // Sauvegarde de la date
            $this->saveLastModifiedKnown($carte->getLastModified());
        }


        $zones = [];
        foreach ($carte->getVigilances() as $zone => $vigilance) {
            $zones[$zone]['vigilance'] = $vigilance;
            $zones[$zone]['types'] = [];
        }

        foreach (Carte::getZones() as $zone_nom => $z) {
            foreach (Objet::getObjets() as $objet_id => $objet) {
                $search = new Search($carte, $objet, $z);
                if ($search->match()) {
                    $zones[$zone_nom]['types'][] = $objet_id;
                }
            }
        }

        // Add St Barth
        $zones['st-barth'] = $zones['st-martin'];

        $this->vigilances = $zones;
    }

    /**
     * @return Carbon
     */
    public function date()
    {
        return $this->carte->getLastModified();
    }

    /**
     * @return null|Carbon
     */
    protected function getlastModifiedKnown()
    {
        $last_check = file_get_contents($this->nom_fichier_date);
        return Carbon::createFromFormat('Y-m-d H:i:s', $last_check, 'UTC');
    }

    protected function saveLastModifiedKnown(Carbon $date)
    {
        file_put_contents($this->nom_fichier_date, $date->format('Y-m-d H:i:s'));
    }



    public function getIterator()
    {
        return new ArrayIterator($this->vigilances);
    }
}
