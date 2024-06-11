<?php
$loader = require 'vendor/autoload.php';

use KingArthurFamily\Processor;
use KingArthurFamily\Constants\SystemConstants;

use KingArthurFamily\Tree\Family;

$family = new Family();
$processor = new Processor();

try {
    if ($argc < 2) {
        throw new Exception("Kindly specify a file path as an argument.\n");
    }
    $processor->processFile($family, SystemConstants::INIT_FILE, $isInitFile = true);
    $processor->processFile($family, $argv[1], $isInitFile = false);

} catch (Exception $e) {
    echo "Please enter valid file location(s)! $e";
}