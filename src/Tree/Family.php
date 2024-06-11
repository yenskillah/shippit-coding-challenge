<?php
namespace KingArthurFamily\Tree;

use KingArthurFamily\Constants\AttributeConstants;
use KingArthurFamily\Constants\RelationshipConstants;
use KingArthurFamily\Constants\SystemConstants;
use KingArthurFamily\Interfaces\FamilyInterface;
use KingArthurFamily\Interfaces\PersonInterface;

class Family implements FamilyInterface
{
    private ?PersonInterface $headOfTheFamily;

    public function __construct()
    {
        $this->headOfTheFamily = null;
    }

    public function setHeadOfTheFamily(string $name, string $gender): void
    {
        $this->headOfTheFamily = new Person($name, $gender, null, null);
    }

    public function getHeadOfTheFamily(): ?PersonInterface
    {
        return $this->headOfTheFamily;
    }

    public function setChild(string $targetMother, string $childName, string $gender): string
    {
        $targetMother = $this->findPerson($this->headOfTheFamily, $targetMother);
        if (!$targetMother) {
            return SystemConstants::PERSON_NOT_FOUND;
        }

        if ($childName === "" || $gender === "") {
            return SystemConstants::CHILD_ADDITION_FAILED;
        }

        if ($targetMother->getGender() !== AttributeConstants::FEMALE) {
            return SystemConstants::CHILD_ADDITION_FAILED;
        }

        $child = new Person($childName, $gender, $targetMother->getSpouse(), $targetMother);
        $targetMother->setChild($child);
        if ($targetMother->getSpouse()) {
            $targetMother->getSpouse()->setChild($child);
        }
        return SystemConstants::CHILD_ADDITION_SUCCESSFUL;
    }

    public function setSpouse(string $targetPerson, string $spouseName, string $gender): ? PersonInterface
    {
        $targetPerson = $this->findPerson($this->headOfTheFamily, $targetPerson);
        if ($targetPerson !== null && !$targetPerson->getSpouse()) {
            $person = new Person($spouseName, $gender, null, null);
            $person->setSpouse($targetPerson);
            $targetPerson->setSpouse($person);
        }

        return $targetPerson;
    }

    public function findRelationship(string $targetPerson, string $relationship): string
    {
        if (!$targetPerson) {
            return SystemConstants::PERSON_NOT_FOUND;
        }

        if (!$relationship) {
            return SystemConstants::RELATIONSHIP_MUST_NOT_BE_EMPTY;
        }

        $person = $this->findPerson($this->headOfTheFamily, $targetPerson);
        if (!$person) {
            return SystemConstants::PERSON_NOT_FOUND;
        }

        $gender = "";
        if (!in_array($relationship, RelationshipConstants::NO_GENDER_IDENTITY)) {
            if (!array_key_exists($relationship, RelationshipConstants::GENDER_IDENTITY)) {
                return AttributeConstants::NONE;
            }
            $gender = RelationshipConstants::GENDER_IDENTITY[$relationship];
        }

        switch ($relationship) {
            case RelationshipConstants::SIBLINGS:
                $result = $person->fetchSiblings();
                return !$result ? AttributeConstants::NONE : $result;
            case RelationshipConstants::SON:
            case RelationshipConstants::DAUGHTER:
                $result = $person->fetchChildren(null,$gender);
                return !$result ? AttributeConstants::NONE : $result;
            case RelationshipConstants::PATERNAL_UNCLE:
            case RelationshipConstants::PATERNAL_AUNT:
                if (!$person->getFather()) {
                    return AttributeConstants::NONE;
                }
                $result = $person->getFather()->fetchSecondRelatives($gender);
                return !$result ? AttributeConstants::NONE : $result;               
            case RelationshipConstants::MATERNAL_UNCLE:
            case RelationshipConstants::MATERNAL_AUNT:
                if (!$person->getMother()) {
                    return AttributeConstants::NONE;
                }
                $result = $person->getMother()->fetchSecondRelatives($gender);
                return !$result ? AttributeConstants::NONE : $result;
            case RelationshipConstants::BROTHER_IN_LAW:
            case RelationshipConstants::SISTER_IN_LAW:
                $result = $this->fetchInLaws($person, $gender);
                return !$result ? AttributeConstants::NONE : $result;
            default:
                return AttributeConstants::NONE;
        }
    }

    private function fetchInLaws(PersonInterface $person, string $gender): string
    {
        $personName = $person->getName();
        $result = "";
        if ($person->getMother() !== null) {
            foreach ($person->getMother()->getChildren() as $child) {
                if ($personName !== $child->getName() && $child->getGender() !== $gender) {
                    if ($child->getSpouse() !== null) {
                        $result .= $child->getSpouse()->getName() . " ";
                    }
                }
            }
        } elseif ($person->getSpouse() !== null && $person->getSpouse()->getMother() !== null) {
            $result .= $person->getSpouse()->getMother()->fetchChildren($person->getSpouse()->getName(), $gender);
        }
        return trim($result);
    }

    private function findPerson(?PersonInterface $headOfTheFamily, string $name): ?PersonInterface
    {
        if (!$headOfTheFamily || !$name) {
            return null;
        }

        if ($headOfTheFamily->getSpouse() !== null && $headOfTheFamily->getSpouse()->getName() === $name) {
            return $headOfTheFamily->getSpouse();
        }

        if ($headOfTheFamily->getName() === $name) {
            return $headOfTheFamily;
        }

        $children = $headOfTheFamily->getChildren();
        foreach ($children as $child) {
            $person = $this->findPerson($child, $name);
            if ($person !== null) {
                return $person;
            }
        }

        return null;
    }
}
