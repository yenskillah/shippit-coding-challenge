<?php
namespace KingArthurFamily\Interfaces;

interface FamilyInterface
{
    public function setHeadOfTheFamily(string $name, string $gender): void;
    public function setSpouse(string $targetPerson, string $spouseName, string $gender): ? PersonInterface;
    public function setChild(string $targetMother, string $childName, string $gender): string;
    public function findRelationship(string $targetPerson, string $relationship): string;
    
}