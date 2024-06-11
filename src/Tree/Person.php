<?php
namespace KingArthurFamily\Tree;

use KingArthurFamily\Interfaces\PersonInterface;

class Person implements PersonInterface
{
    private ?PersonInterface $father;
    private ?PersonInterface $mother;
    private ?PersonInterface $spouse;
    private array $children = [];
    private string $name;
    private string $gender;

    public function __construct(string $name, string $gender, ?PersonInterface $father = null, ?PersonInterface $mother = null)
    {
        $this->setName($name);
        $this->setGender($gender);
        $this->setMother($mother);
        $this->setFather($father);
        $this->spouse = null;
    }

    private function setName(string $name): void {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    private function setGender(string $gender): void {
        $this->gender = $gender;
    }

    public function getGender(): string {
        return $this->gender;
    }

    private function setFather(?PersonInterface $father): void {
        $this->father = $father;
    }

    public function getFather(): ?PersonInterface {
        return $this->father;
    }

    private function setMother(?PersonInterface $mother): void {
        $this->mother = $mother;
    }

    public function getMother(): ?PersonInterface {
        return $this->mother;
    }

    public function setSpouse(?PersonInterface $spouse): void {
        $this->spouse = $spouse;
    }

    public function getSpouse(): ?PersonInterface {
        return $this->spouse;
    }

    public function setChild(PersonInterface $child): void {
        $this->children[] = $child;
    }

    public function getChildren(): array {
        return $this->children;
    }

    public function fetchChildren(?string $name = null, string $gender): string {
        $children = "";
        foreach ($this->children as $child) {
            if ($name !== null && $name === $child->getName()){
                continue;
            }
            if ($child->getGender() === $gender){
                $children .= $child->getName() . " ";
            }
        }
        return trim($children);
    }

    public function fetchSiblings(): string {
        $siblings = "";
        if (!$this->getMother()) {
            return $siblings;
        }

        foreach ($this->getMother()->getChildren() as $child) {
            if ($this->getName() === $child->getName()){
                continue;
            }
            $siblings .= $child->getName() . " ";
        }
        return trim($siblings);
    }

    public function fetchSecondRelatives(string $gender): string {
        $secondRelatives = "";
        if (!$this->getMother()) {
            return $secondRelatives;
        }

        foreach ($this->getMother()->getChildren() as $child) {
            if ($this->getName() === $child->getName()){
                continue;
            }

            if ($child->getGender() === $gender){
                $secondRelatives .= $child->getName() . " ";
            }   
        }

        return trim($secondRelatives);
    }
}