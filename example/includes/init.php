<?php
require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../config.php');
require(__DIR__ . '/../includes/App.php');

use Buckaroo\SDK\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NullHandler;
use Buckaroo\SDK\Example\App;

$logger = new Logger('buckaroo-sdk');
if ($debug) {
    $logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
} else {
    $logger->pushHandler(new NullHandler());
}

$client = new Client($logger);
$client->setWebsiteKey($websiteKey);
$client->setSecretKey($secretKey);
$client->setMode(Client::MODE_TEST);

$app = new App($logger);