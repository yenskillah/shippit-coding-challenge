<?php
namespace KingArthurFamily\Interfaces;
use KingArthurFamily\Tree\Family;
interface ProcessorInterface
{
    public function process(Family $family, string $command): string;
}