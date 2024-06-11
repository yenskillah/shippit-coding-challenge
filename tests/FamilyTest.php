<?php

use KingArthurFamily\Constants\AttributeConstants;
use KingArthurFamily\Constants\RelationshipConstants;
use PHPUnit\Framework\TestCase;
use KingArthurFamily\Tree\Family;
use KingArthurFamily\Constants\SystemConstants;
use KingArthurFamily\Processor;

class FamilyTest extends TestCase
{
    private Family $family;
    private Processor $processor;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->family = new Family();
        $this->processor = new Processor();
        $this->processor->processFile( $this->family, SystemConstants::INIT_FILE, true);
    }

    /** @test */ 
    public function it_should_add_a_child_through_a_mother()
    {
        $result = $this->family->setChild("Flora", "Dominique", AttributeConstants::FEMALE);
        $this->assertEquals(SystemConstants::CHILD_ADDITION_SUCCESSFUL, $result);
    }

    /** @test */ 
    public function it_should_fetch_the_relationship_for_siblings()
    {
        $result = $this->family->findRelationship("Victorie", RelationshipConstants::SIBLINGS);
        $this->assertEquals("Dominique Louis", $result);
    }

    /** @test */ 
    public function it_should_return_none_when_there_is_no_siblings()
    {
        $result = $this->family->findRelationship("Remus", RelationshipConstants::SIBLINGS);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_sons()
    {
        $result = $this->family->findRelationship("Malfoy", RelationshipConstants::SON);
        $this->assertEquals("Draco", $result);
    }    

    /** @test */ 
    public function it_should_return_none_when_there_is_no_sons()
    {
        $result = $this->family->findRelationship("Percy", RelationshipConstants::SON);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_daughters()
    {
        $result = $this->family->findRelationship("Malfoy", RelationshipConstants::DAUGHTER);
        $this->assertEquals("Aster", $result);
    }    

    /** @test */ 
    public function it_should_return_none_when_there_is_no_daughters()
    {
        $result = $this->family->findRelationship("Victorie", RelationshipConstants::DAUGHTER);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_paternal_uncles()
    {
        $result = $this->family->findRelationship("Ron", RelationshipConstants::PATERNAL_UNCLE);
        $this->assertEquals("James", $result);
    }  

    /** @test */ 
    public function it_should_return_none_when_there_is_no_paternal_uncles()
    {
        $result = $this->family->findRelationship("Remus", RelationshipConstants::PATERNAL_AUNT);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_paternal_aunt()
    {
        $result = $this->family->findRelationship("Ron", RelationshipConstants::PATERNAL_AUNT);
        $this->assertEquals("Lily", $result);
    } 

    /** @test */ 
    public function it_should_return_none_when_there_is_no_paternal_aunt()
    {
        $result = $this->family->findRelationship("Remus", RelationshipConstants::PATERNAL_AUNT);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_maternal_uncles()
    {
        $result = $this->family->findRelationship("Remus", RelationshipConstants::MATERNAL_UNCLE);
        $this->assertEquals("Louis", $result);
    } 

    /** @test */ 
    public function it_should_return_none_when_there_is_no_maternal_uncles()
    {
        $result = $this->family->findRelationship("Ginny", RelationshipConstants::MATERNAL_UNCLE);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_brother_in_law()
    {
        $result = $this->family->findRelationship("Ted", RelationshipConstants::BROTHER_IN_LAW);
        $this->assertEquals("Louis", $result);
    } 

    /** @test */ 
    public function it_should_return_none_when_there_is_no_brother_in_law()
    {
        $result = $this->family->findRelationship("Rose", RelationshipConstants::BROTHER_IN_LAW);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_fetch_the_relationship_for_sister_in_law()
    {
        $result = $this->family->findRelationship("Darcy", RelationshipConstants::SISTER_IN_LAW);
        $this->assertEquals("Lily", $result);
    } 

    /** @test */ 
    public function it_should_return_none_when_there_is_no_sister_in_law()
    {
        $result = $this->family->findRelationship("Malfoy", RelationshipConstants::SISTER_IN_LAW);
        $this->assertEquals("NONE", $result);
    } 

    /** @test */ 
    public function it_should_not_fetch_relatives_with_a_nil_target_person()
    {
        $result = $this->family->findRelationship("", "Siblings");
        $this->assertEquals(SystemConstants::PERSON_NOT_FOUND, $result);
    }

    /** @test */ 
    public function it_should_not_fetch_relatives_with_a_nil_relation()
    {
        $result = $this->family->findRelationship("Flora", "");
        $this->assertEquals(SystemConstants::RELATIONSHIP_MUST_NOT_BE_EMPTY, $result);
    }

    /** @test */    
    public function it_should_not_add_a_child_when_required_values_are_null(){
        $result = $this->family->setChild("", "", "");
        $this->assertEquals(SystemConstants::PERSON_NOT_FOUND, $result);
    }

    /** @test */  
    public function it_should_not_add_a_child_when_name_is_null(){
        $result = $this->family->setChild("Flora", "", AttributeConstants::FEMALE);
        $this->assertEquals(SystemConstants::CHILD_ADDITION_FAILED, $result);
    }

    /** @test */  
    public function it_should_not_add_a_child_when_gender_id_null(){
        $result = $this->family->setChild("Flora", "Minerva", "");
        $this->assertEquals(SystemConstants::CHILD_ADDITION_FAILED, $result);
    }

    /** @test */ 
    public function it_should_not_add_a_child_when_adding_through_father(){
        $result = $this->family->setChild("King Arthur", "Ginerva", AttributeConstants::FEMALE);
        $this->assertEquals(SystemConstants::CHILD_ADDITION_FAILED, $result);
    }

    /** @test */ 
    public function it_should_not_add_a_child_when_adding_to_non_existing_member(){
        $result = $this->family->setChild("Florie", "Victorie", AttributeConstants::FEMALE);
        $this->assertEquals(SystemConstants::PERSON_NOT_FOUND, $result);
    }
    protected function tearDown(): void
    {
        unset($this->family);
    }
}