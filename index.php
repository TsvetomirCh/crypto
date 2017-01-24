<?php

use Crypto\Caesar;
use Crypto\Playfair;
use Crypto\Str;

require_once 'vendor/autoload.php';

$string = Str::prepareTheText(readline("Enter the text message: "));
$key = Str::prepareTheText(readline("Playfair key: "));

if (!ctype_alpha($string) || !ctype_alpha($key)) {
    throw new InvalidArgumentException("Invalid input.");
}

$caesar = new Caesar();
$playfair = new Playfair($key);

echo "--- Encrypted using Caesar ---" . PHP_EOL;
echo $msg = $caesar->encrypt($string) . PHP_EOL;
echo "--- Encrypted using Playfair --- " . PHP_EOL;
echo $msg = $playfair->encrypt($msg) . PHP_EOL;
echo "--- Decrypt using Playfair --- " . PHP_EOL;
echo $msg = $playfair->decrypt($msg) . PHP_EOL;
echo "--- Decrypt using Caesar --- " . PHP_EOL;
echo $caesar->decrypt($msg) . PHP_EOL;