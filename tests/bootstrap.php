<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/4
 * Time: 21:05
 */

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

include '../vendor/autoload.php';

$host = 'http://localhost:4444/wd/hub'; // this is the default

$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities, 5000);

\flwt\UrlHandler::setPrefix("http://localhost");

\flwt\Resource::create($driver);