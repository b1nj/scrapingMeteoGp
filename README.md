# ScrapingMeteoGp

Script php pour récupérer sur le site http://www.meteofrance.gp les vigilances météo des Antilles Française. 

Les couleurs (verte, jaune, orange, rouge, violette, grise) et les types de vigilance (vent, vague, pluie, cyclone) sont récupérés à partir de l'aimage ci-dessous.

Ce script est utilisé pour le site http://www.alerte.mq/.

![Carte vigilance cyclone Irma](tests/datas/test4.png?raw=true)
*Carte météo France pendant le cyclone Irma en septembre 2017 - http://www.meteofrance.gp/integration/sim-portail/generated/integration/img/vigilance/fr_99.gif *

## Installation

Installation method via composer. Add this code in your composer.json.

```
"repositories": [
    {
        "type": "vcs",
        "url":  "https://github.com/b1nj/scrapingMeteoGp.git"
    }
],
```
And execute this command :

```
$ composer require bnj/scrapingMeteoGp
```

## Usage

The simplest usage of the library would be as follows:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use B1nj\ScrapingMeteoGp\Scraping;

$zones = new Scraping();
var_dump($zones);
```
To not load the image each time.

```php
$zones = new Scraping(null, 'tmp/meteogp_lastmodified.txt');
```

## Unit Testing

Unit testing for ScrapingMeteoGp is done using PHPUnit.

To execute tests, run vendor/bin/phpunit from the command line while in the root directory.