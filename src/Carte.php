<?php
namespace B1nj\ScrapingMeteoGp;

use B1nj\ScrapingMeteoGp\Exception\CarteException;
use Carbon\Carbon;

/**
 * Class Carte
 * @package B1nj\ScrapingMeteoGp
 */
class Carte
{
    protected $filename;

    protected $gd_resource;
    protected $http_response_header;

    const URL = 'https://rpcache-aa.meteofrance.com/internet2018client/2.0/report?domain=VIGI972&report_type=vigilance&report_subtype=version%20PDF&token=__Wj7dVSTjV9YGu1guveLyDq0g7S7TfTjaHBTPTpO0kj8__';

    /**
     * Carte constructor.
     * @param $filename
     */
    public function __construct($filename = null)
    {
        $this->filename = !is_null($filename) ? $filename : self::URL;
    }

    public function get($check = true)
    {
        $this->gd_resource = imagecreatefromstring($this->fileGetContents());

        if ($check) {
            $this->checkImage();
        }
    }

    public function getZonesPointVigilance()
    {
        return [
            'martinique' => [338, 372],
            'guadeloupe' => [289, 228],
            'st-martin' => [65, 44],
            'guyane-ne' => [589, 483],
            'guyane-nw' => [528, 447],
            'guyane-centre' => [550, 512],
            'guyane-sud' => [533, 550],
        ];
    }

    public static function getZones()
    {
        return [
            'martinique' => [[270, 310], [450, 420]],
            'guadeloupe' => [[240, 174], [430, 300]],
            'st-martin' => [[12, 8], [252, 128]],
            'guyane-ne' => [[562, 412], [612, 507]],
            'guyane-nw' => [[505, 408], [570, 488]],
            'guyane-centre' => [[500, 492], [610, 542]],
            'guyane-sud' => [[500, 537], [600, 572]],
        ];
    }

    /**
     * @param $x
     * @param $y
     * @return Pixel
     */
    public function getPixell($x, $y)
    {
        return new Pixel($x, $y, $this->gd_resource);
    }


    public function getVigilances()
    {
        $vigilances = [];
        foreach ($this->getZonesPointVigilance() as $zone => $position) {
            $couleur = $this->getPixell($position[0], $position[1])->couleur();
            $vigilances[$zone] = $couleur->isVigilance() ? $couleur->getName() : null;
        }

        return $vigilances;
    }


    /**
     * @return bool
     */
    public function isHttpCarte()
    {
        return filter_var($this->filename, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * @throws CarteException
     */
    protected function checkImage()
    {
        if ($this->width() != 620 or $this->height() != 580) {
            throw new CarteException("La carte n'est pas conforme");
        }
    }

    public function width()
    {
        return imagesx($this->gd_resource);
    }

    public function height()
    {
        return imagesy($this->gd_resource);
    }

    /**
     * @param $date Carbon
     * @return bool
     */
    public function hasNewUpdate(Carbon $date)
    {
        return $this->getLastModified() > $date;
    }

    /**
     * @return Carbon
     */
    public function getLastModified()
    {
        return $this->isHttpCarte() ? $this->getHeaderLastModified() : Carbon::now();
    }

    /**
     * @return null|Carbon
     * @throws CarteException
     * http://stackoverflow.com/questions/8429342/php-get-headers-set-temporary-stream-context
     */
    protected function getHeaderLastModified()
    {
        if ($this->http_response_header === null) {
             $this->fileGetContents(true);
        }

        foreach ($this->http_response_header as $ligne) {
            if (strpos($ligne, 'Last-Modified:') !== false) {
                try {
                    $last_modified = str_replace('Last-Modified:', '', $ligne);
                    return Carbon::createFromFormat('D, d M Y H:i:s \G\M\T', trim($last_modified), 'UTC');
                } catch (\InvalidArgumentException $exception)  { }
            }
        }

        throw new CarteException("Impossible de récupèrer le header Last-Modified");
    }

    protected function fileGetContents($header = false)
    {
        $context = null;

        if ($header) {
            $options = array(
                'http' => array(
                    'method' => 'HEAD',
                    'follow_location' => 0
                )
            );
            $context = stream_context_create($options);
        }

        $contents = @file_get_contents($this->filename, null, $context);

        if ($header or $contents !== false) {
            // $http_response_header variable magique contenant l'en-têtes de réponse HTTP
            if ($this->isHttpCarte()) {
                $this->http_response_header = $http_response_header;
            }
            return $contents;
        }

        throw new CarteException("Impossible de récupèrer la carte");
    }
}
