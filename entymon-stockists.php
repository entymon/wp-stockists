<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 22/05/2018
 * Time: 18:42
 *
 * @package entymon-stockists
 * @version 1.0
 *
 * Plugin Name: Entymon Stockists
 * Description: example of code
 * Author: entymon
 * Version: 1.0
 *
 */

require_once __DIR__ . '/constants.php';

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Entymon\\Stockists\\', __DIR__);

$stockists = new \Entymon\Stockists\Api\StockistController();
$stockists->init();

$dashboard = new \Entymon\Stockists\App\Dashboard();
$dashboard->init();

$metaBox = new \Entymon\Stockists\App\MetaBox();
$metaBox->init();

$countryImage = new Entymon\Stockists\App\CountryImage();
$countryImage-> init();

$countryIsoCode = new \Entymon\Stockists\App\CountryIsoCodeField();
$countryIsoCode->init();

$regionOrderField = new \Entymon\Stockists\App\RegionOrderField();
$regionOrderField->init();

$view = new \Entymon\Stockists\App\View();
$view->init();
