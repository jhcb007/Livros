<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 02/06/2017
 * Time: 16:47
 */

error_reporting(-1);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
$fetcher = new Fetcher($client);
echo $fetcher->pesquisa_all('Teoria');