<?php

use KingArthurFamily\Constants\AttributeConstants;
use PHPUnit\Framework\TestCase;
use KingArthurFamily\Tree\Person;
use KingArthurFamily\Interfaces\PersonInterface;

class PersonTest extends TestCase
{
    /** @test */ 
    public function it_should_perform_a_person_initialization(): void
    {
        $person = new Person('King Arthur', AttributeConstants::MALE);
        $this->assertInstanceOf(PersonInterface::class, $person);
        $this->assertEquals('King Arthur', $person->getName());
        $this->assertEquals(AttributeConstants::MALE, $person->getGender());
        $this->assertNull($person->getFather());
        $this->assertNull($person->getMother());
        $this->assertNull($person->getSpouse());
        $this->assertIsArray($person->getChildren());
        $this->assertEmpty($person->getChildren());
    }

    /** @test */ 
    public function it_should_set_and_get_the_father(): void
    {
        $father = new Person('Uther', AttributeConstants::MALE);
        $person = new Person('Arthur', AttributeConstants::MALE, $father);
        $this->assertSame($father, $person->getFather());
    }

    /** @test */ 
    public function it_should_set_and_get_the_mother(): void
    {
        $mother = new Person('Igraine', AttributeConstants::FEMALE);
        $person = new Person('Arthur', AttributeConstants::MALE, null, $mother);
        $this->assertSame($mother, $person->getMother());
    }

    /** @test */ 
    public function it_should_set_and_get_the_spouse(): void
    {
        $person = new Person('Arthur', AttributeConstants::MALE);
        $spouse = new Person('Guinevere', AttributeConstants::FEMALE);
        $person->setSpouse($spouse);
        $this->assertSame($spouse, $person->getSpouse());
    }

    /** @test */ 
    public function it_should_set_and_get_the_children(): void
    {
        $person = new Person('Arthur', AttributeConstants::MALE);
        $child1 = new Person('Mordred', AttributeConstants::MALE);
        $child2 = new Person('Gawain', AttributeConstants::MALE);
        $person->setChild($child1);
        $person->setChild($child2);
        $children = $person->getChildren();
        $this->assertCount(2, $children);
        $this->assertSame($child1, $children[0]);
        $this->assertSame($child2, $children[1]);
    }

    /** @test */ 
    public function it_should_fetch_the_children(): void
    {
        $person = new Person('Arthur', AttributeConstants::MALE);
        $child1 = new Person('Mordred', AttributeConstants::MALE);
        $child2 = new Person('Gawain', AttributeConstants::MALE);
        $child3 = new Person('Elaine', AttributeConstants::FEMALE);
        $person->setChild($child1);
        $person->setChild($child2);
        $person->setChild($child3);

        $this->assertEquals('Mordred Gawain', $person->fetchChildren(null, AttributeConstants::MALE));
        $this->assertEquals('Elaine', $person->fetchChildren(null, AttributeConstants::FEMALE));
    }

    /** @test */ 
    public function it_should_fetch_the_siblings(): void
    {
        $mother = new Person('Igraine', AttributeConstants::FEMALE);
        $child1 = new Person('Arthur', AttributeConstants::MALE, null, $mother);
        $child2 = new Person('Morgana', AttributeConstants::FEMALE, null, $mother);
        $child3 = new Person('Elaine', AttributeConstants::FEMALE, null, $mother);

        $mother->setChild($child1);
        $mother->setChild($child2);
        $mother->setChild($child3);

        $this->assertEquals('Morgana Elaine', $child1->fetchSiblings());
        $this->assertEquals('Arthur Elaine', $child2->fetchSiblings());
        $this->assertEquals('Arthur Morgana', $child3->fetchSiblings());
    }

    /** @test */ 
    public function it_should_fetch_the_second_relatives(): void
    {
        $mother = new Person('Igraine', AttributeConstants::FEMALE);
        $child1 = new Person('Morgana', AttributeConstants::FEMALE, null, $mother);
        $child2 = new Person('Ela', AttributeConstants::FEMALE, null, $mother);
        $child3 = new Person('John', AttributeConstants::MALE, null, $mother);
        $child4 = new Person('Eddie', AttributeConstants::MALE, null, $mother);
        
        $mother->setChild($child1);
        $mother->setChild($child2);
        $mother->setChild($child3);
        $mother->setChild($child4);

        $subChild1 = new Person('Ana', AttributeConstants::FEMALE, null, $child1);
        $subChild2 = new Person('Eva', AttributeConstants::FEMALE, null, $child2);

        $child1->setChild($subChild1);
        $child2->setChild($subChild2);

        $this->assertEquals('Ela', $subChild1->getMother()->fetchSecondRelatives(AttributeConstants::FEMALE));
        $this->assertEquals('John Eddie', $subChild2->getMother()->fetchSecondRelatives(AttributeConstants::MALE));
    }
}