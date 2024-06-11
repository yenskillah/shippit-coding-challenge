<?php
namespace KingArthurFamily\Interfaces;

interface PersonInterface
{
    public function __construct(string $name, string $gender, ?PersonInterface $father = null, ?PersonInterface $mother = null);
    public function getName(): string;
    public function getGender(): string;
    public function getFather(): ?PersonInterface;
    public function getMother(): ?PersonInterface;
    public function setSpouse(?PersonInterface $spouse): void;
    public function getSpouse(): ?PersonInterface;
    public function setChild(PersonInterface $child): void;
    public function getChildren(): array;
    public function fetchChildren(?string $name = null, string $gender): string;
    public function fetchSiblings(): string;
    public function fetchSecondRelatives(string $gender): string;
}